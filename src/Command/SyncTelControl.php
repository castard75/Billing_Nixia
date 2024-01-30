<?php
// src/Command/CreateUserCommand.php
namespace App\Command;
use App\Entity\Cdr;
use App\Entity\Telephone;
use App\Entity\History;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\ProgressBar;


// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:syncphone')]
class SyncTelControl extends Command
{

    private $desc;
    public function __construct(
      
        EntityManagerInterface $em
    ) {

        $this->em = $em;
        parent::__construct();
    }
    

    protected function configure ():void{

$this->desc = $this->setDescription("check et ajout de téléphones");
    }


    protected function execute(InputInterface $input, OutputInterface $output ): int
    {
        $progressBar = new ProgressBar($output, 50);
        $i = 0;

        while ($i++ < 50) {
        $process = $this->chekCdr();
        $progressBar->advance();
            
        }
      
        $progressBar->finish();
        return Command::SUCCESS;

    }


    public function chekCdr(): bool
    {
        try {
        
            $telRepository = $this->em->getRepository(Telephone::class);
            $telephones = $telRepository->findAll();
    
           //Récupération de tout les numéro de téléphones
            $existingPhoneNames = [];
            foreach ($telephones as $telephone) {
                $existingPhoneNames[] = $telephone->getName();
            }
    
          
            $cdrRepository = $this->em->getRepository(CDR::class);
            $cdrQueryBuilder = $cdrRepository->createQueryBuilder('c');

            //Recupération des valeurs unique dans le champ caller
            $cdrQueryBuilder->where($cdrQueryBuilder->expr()->like('c.caller', ':caller'))
                ->setParameter('caller', '+%');
            $cdrQueryBuilder->select('DISTINCT c.caller');
            $resultCdr = $cdrQueryBuilder->getQuery()->getResult();
    
       
            foreach ($resultCdr as $cdrResult) {
                $callerName = $cdrResult['caller'];
                //Si le numéro n'est pas dans la table télephone on l'envoie en bdd
                if (!in_array($callerName, $existingPhoneNames)) {
             
                    $newTelephone = new Telephone();
                    $newTelephone->setName($callerName);
                    $this->em->persist($newTelephone);
                  
                      //Ajout dans history
                      $history = (new History())  
                      ->setTitle("Nouveau numéro")
                      ->setDescription("Le numéro"." " .  $callerName . " a été ajouté ");
                      $this->em->persist($history);
                      $this->em->flush();
                }


            }


                   //Mise à jour des status des CDR à 2
    
                  $cdrRepository->createQueryBuilder('c')
                  ->update()
                  ->set('c.status', 2)
                  ->getQuery()
                  ->execute();

    
       
            $this->em->flush();
    
        } catch (\Exception $e) {
            return false;
        }
    
        return true;
    }
    


}