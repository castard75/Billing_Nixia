<?php

namespace App\Command;

use App\Entity\Contracts;
use App\Entity\Customers;
use App\Entity\Customerscontact;
use App\Entity\Myconnectors;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:syncontacts',
)]
class SyncContacts extends Command
{
    private $entityManager;
    private $ClientHTTP;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setName('SyncCustomers')
            ->setDescription('Synchronistaion des contacts')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ListeConnector = $this->entityManager->getRepository(Myconnectors::class)->createQueryBuilder('u')->where('u.url IS NOT NULL')->getQuery()->execute();
        foreach ($ListeConnector as $Val){
            //Récupere les infos Doli
            $OrigineId = $Val->getId();
            $UrlApi = $Val->getUrl();
            $TokenApi = $Val->getLogin();

            $this->recupererListeContact($OrigineId, $UrlApi, $TokenApi);
        }

        return Command::SUCCESS;
    }

    private function recupererListeContact($OrigineId, $UrlApi, $TokenApi){
        $em = $this->entityManager;

        $this->ClientHTTP = HttpClient::create()->withOptions([
            'headers' => [
                'Accept' => 'application/json',
                'DOLAPIKEY' => $TokenApi
            ]
        ]);

        $RequeteApi = $this->ClientHTTP->request("GET", $UrlApi."/contacts?sortfield=t.rowid&sortorder=ASC&limit=100000");
        if($RequeteApi->getStatusCode() == 200){
            $content = json_decode($RequeteApi->getContent(), true);

            foreach($content as $resultat)
            {
                $Id = $resultat['id'];
                $ClientId = NULL;
                if(trim($resultat['socid']) != ""){
                    $occurence2 = $em->getRepository(Customers::class)
                        ->findOneBy(array(
                            "dolid" => trim($resultat['socid']),
                            "origineid" => $OrigineId
                        ));
                    if($occurence2) {
                        $ClientId = $em->getReference('App\Entity\Customers', $occurence2->getId());
                    }
                }

                $Lastname = $resultat['lastname'];
                $Firstname = $resultat['firstname'];
                $poste = $resultat['poste'];
                $Email = $resultat['email'];
                $UpdatedCustomer = new DateTimeImmutable(date('Y-m-d H:m:s', $resultat['date_modification']));

                $occurence = $em->getRepository(Customerscontact::class)
                    ->findOneBy(array(
                        "dolid" => $Id,
                        "origineid" => $OrigineId
                    ));

                if(is_null($occurence)) {
                    $tp_entity = new Customerscontact();
                    $tp_entity
                        ->setLastname($Lastname)
                        ->setFirstname($Firstname)
                        ->setPoste($poste)
                        ->setEmail($Email)
                        ->setClientid($ClientId)
                        ->setCreatedat(NULL)
                        ->setUpdatedat($UpdatedCustomer)
                        ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                        ->setDolid($Id);
                    $em->persist($tp_entity);
                }else{
                    $occurence
                        ->setLastname($Lastname)
                        ->setFirstname($Firstname)
                        ->setPoste($poste)
                        ->setEmail($Email)
                        ->setClientid( $ClientId)
                        ->setCreatedat(NULL)
                        ->setUpdatedat($UpdatedCustomer)
                        ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                        ->setDolid($Id);
                    $em->persist($occurence);
                }
                $em->flush();
            }
        }
    }
}