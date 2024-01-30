<?php

namespace App\Command\voxnode;

use DateTimeImmutable;



// use App\Entity\Voxwide;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Cdr;
use App\Entity\Sda;
use App\Entity\Cds;
use App\Entity\ParamSDA;
use App\Entity\IndicatifSda;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use League\Csv\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\ProgressBar;

#[AsCommand('app:voxwide', 'Sync email from ovh')]
class VoxwideCommand extends Command
{



    public function __construct(
        ParameterBagInterface $parameterBag,
        EntityManagerInterface $em
    ) {
        $this->parameterBag = $parameterBag;
        $this->em = $em;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Gestion CSV ');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);


        $dir = __DIR__ . '/../../../public/uploads/imports/voxnode';
        $dir2 = __DIR__ . '/../../../public/uploads/processed/';



        $files = scandir($dir);


        foreach ($files as $file) {

            if (pathinfo($file, PATHINFO_EXTENSION) == 'csv') {
                try {
 

                $processing = $this->csvProcessing($dir . '/' . $file);


                if (!$processing) {
                    $io->error('Erreur lors du traitement du fichier ' . $file);
                    return 1;
                } else {

                    $filename_date = new \DateTime();


                    $extension = pathinfo($file, PATHINFO_EXTENSION);


                    $baseName = basename($file, '.' . $extension);

                    rename($dir .  '/' . $file, $dir2 . $baseName .  '-' . $filename_date->format('Y_m_d_H_i_s') . '.' . $extension);


             
                    $io->success('File ' . $file . ' processed successfully');
                }
            } catch(\Exception $e){
                $io->error('Erreur lors du traitement du fichier ' . $file . ': ' . $e->getMessage());
              

            }} 
        }



        return 0;
    }


    public function csvProcessing(string $pathFile ): bool
    {

        try {
            $csv = Reader::createFromPath($pathFile, 'r');
            $filename_date = new \DateTime();
            $filename_string = $filename_date->format('Y-m-d H:i:s');
            $dateString = "01-01-2023 03:28:52";
            $format = "d-m-Y H:i:s";
            $createdDateImmutable = DateTimeImmutable::createFromFormat($format, $dateString);

            // envoie des données par paquets de 20 pour ne pas saturer la mémoire
            $batchSize = 20;
            $count = 0;
            $checkPhoneNumber = [];

            foreach ($csv as $col) {
                $dateImmutable = DateTimeImmutable::createFromFormat($format, $col[4]);                
                $existingCDR = $this->em->getRepository(CDR::class)->findOneBy([
                    'sipTrunk' => $col[1],
                    'caller' => $col[2],
                    'called' => $col[3],
                    'dateAt' => $dateImmutable,
                ]);
              
                $Sda_entity = new Sda();
                if (!$existingCDR) {
                $voxwide = (new CDR())
                    ->setSiptrunk($col[1])
                    ->setCaller($col[2])
                    ->setCalled($col[3])
                    ->setDateAt($dateImmutable)
                    ->setOrigin("Voxnode")
                    ->setPrice($col[6])
                    ->setAnomaly(false)
                    ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s')))
                    ->setOriginId("0")
                    ->setDevise("Eur")
                    ->setstatus("1")
                    ->setEtat("0")
                    ->setActivate("0");


                //Condition pour vérifier si le numéro est correcte 
                if ($this->checkNumberLength($voxwide->getCalled())) {

                    dump($voxwide->getCalled());
                    $voxwide->setAnomaly("1")
                        ->setComment("Numéro incomplet");
                }
                // Vérifie s'il y a l'indicatif "+262" dans le numéro
                if (substr_count($col[3], "+262692")) {

                    $voxwide->setType(1);
                } elseif (substr_count($col[3], "+262693")) {

                    $voxwide->setType(1);
                } elseif (substr_count($col[3], "+336")) {

                    $voxwide->setType(1);
                } elseif (substr_count($col[3], "+262639")) {

                    $voxwide->setType(1);
                } else {

                    $voxwide->setType(0);
                }


                  $caller = $voxwide->getCalled();
               
                   $allIndicatifs = $this->em->getRepository(IndicatifSda::class)->findAll();
             
                
                foreach ($allIndicatifs as $tabIndicatif) {

                    $indicatifTabValue = $tabIndicatif->getIndicatif();
                    $prefixe = $tabIndicatif->getPrefixe();



                      // Vérification si l'indicatif est présent dans le numéro
                     $indicatifPresent = strpos($caller, $indicatifTabValue) !== false;

                      // Vérification si le préfixe est présent dans le numéro
                     $prefixePresent = strpos($caller, $prefixe) !== false;

                      // Vérification si à la fois l'indicatif et le préfixe sont présents
                    if ($indicatifPresent && $prefixePresent) {
   

                                $findRef = $this->em->getRepository(IndicatifSda::class)->findOneBy([
                            
                                 "indicatif" => $indicatifTabValue,
                                 "prefixe" => $prefixe

                                 ]);

                               
                                 $codeIso = $findRef->getCodeIso(); 

                                 $voxwide->setIso($codeIso); }        


                }

             
                $this->em->persist($voxwide);
               
                try {
                    if (($count % $batchSize) === 0) {
                        $this->em->flush(); 
                        $this->em->clear(); // Libère la mémoire
                        $checkPhoneNumber = [];
                    }

                    $count++;
                } catch (\Exception $e) {
                    echo $e;
                }

                
            } else {

                var_dump("Fichier à jour");
           
            }
            }
         
            $this->em->flush();
        } catch (\Exception $e) {
            echo $e;
            return false;
        }

        return true;
    }
  
    


    // Vérication de la longueur du numéro 
    public function checkNumberLength(string $number): bool
    { 
        if (substr_count($number, "+262")) {


            $explod = explode("+262", $number);
        } elseif (substr_count($number, "+33")) {
            $explod = explode("+33", $number);
        } else {
            return true;
        }

        return !(9 == strlen($explod[1]));
    }


    public function checkDevise(string $prix): string
    {
        $explodPrice = explode(" ", $prix);
        $devise = $explodPrice[1];

        return $devise;
    }
}
