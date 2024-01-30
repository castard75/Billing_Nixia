<?php

namespace App\Command;

use App\Entity\Contract;
use App\Entity\Cdr;
use App\Entity\IndicatifSda;
use App\Entity\Sda;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use \DateTimeImmutable;
use \DateTimeZone;


#[AsCommand('app:country', 'Sync cdr caller in sda')]
class IndicatifCommand extends Command
{
    /**
     * Client HTTP
     *
     * @var object
     */
    private $client;
    /**
     * Manages database objects
     *
     * @var object
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        // Initialise the HTTP client with the appropriate headers

    }

    protected function configure()
    {
        $this
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run');
    }



    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);

        try {

            $files = __DIR__ . '/../../public/assets/CountryCodes.json';


            $contenuJson = file_get_contents($files);
            $data = json_decode($contenuJson, true);

            // var_dump($data);
            $count = 0;
            $batchSize = 20;
            foreach ($data as $element) {


                foreach ($element as $country) {




                    // if (isset($country["prefixe"][0])) {
                    //     echo $country["prefixe"][0];
                    // }
                    $label = $country['name'];
                    $iso = $country['iso'];
                    $region = $country['region'];
                    $codeIso = $iso['alpha-2'];
                    $indicatif = $country['phone'][0];

                    $zone = $this->determineTypeByRegion($region);

                    $indicatifSda = new IndicatifSda();
                    $indicatifSda
                        ->setLabel($label)
                        ->setCodeIso($codeIso)
                        ->setZone($zone)
                        ->setIndicatif($indicatif);


                    $this->entityManager->persist($indicatifSda);
                    // Envoi des données par paquet de 20 à la base de données
                    if (($count % $batchSize) === 0) {
                        $this->entityManager->flush(); // Exécute un INSERT INTO pour chaque produit
                        $this->entityManager->clear(); // Libère la mémoire
                    }



                    $count++;
                }

                // $this->entityManager->flush();
            }





            $io->success('Succès');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            return false;
        }
    }




    function determineTypeByRegion($region)
    {
        $type = 0;

        switch ($region) {
            case 'Africa':
                $type = 2;
                break;
                // Ajoutez d'autres cas pour les autres régions si nécessaire
            case 'Asia':
                $type = 8;
                break;

            case 'Europe':
                $type = 3;
                break;

            case 'Americas':
                $type = 1;
                break;
            case 'Oceania':
                $type = 6;
                break;

            default:
                // Cas par défaut si la région ne correspond à aucun des cas spécifiés
                $type = 7;
                break;
        }

        return $type;
    }
}
