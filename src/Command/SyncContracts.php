<?php

namespace App\Command;

use App\Entity\Contracts;
use App\Entity\Customers;
use App\Entity\Myconnectors;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:synccontracts',
)]
class SyncContracts extends Command
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
            ->setDescription('Synchronistaion des contrats')
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

            $this->recupererListeContrat($OrigineId, $UrlApi, $TokenApi);
        }

        return Command::SUCCESS;
    }

    private function recupererListeContrat($OrigineId, $UrlApi, $TokenApi){
        $em = $this->entityManager;

        $this->ClientHTTP = HttpClient::create()->withOptions([
            'headers' => [
                'Accept' => 'application/json',
                'DOLAPIKEY' => $TokenApi
            ]
        ]);

        $RequeteApi = $this->ClientHTTP->request("GET", $UrlApi."/contracts?sortfield=t.rowid&sortorder=ASC&limit=100000");
        if($RequeteApi->getStatusCode() == 200){
            $content = json_decode($RequeteApi->getContent(), true);

            foreach($content as $resultat)
            {
                $Id = trim($resultat['id']);
                $Reference = NULL;
                if(trim($resultat['ref']) != ""){
                    $Reference = trim($resultat['ref']);
                }
                $ReferenceBr = NULL;
                if(trim($resultat['ref_customer']) != ""){
                    $ReferenceBr = trim($resultat['ref_customer']);
                }
                $RefExt = NULL;
                if(trim($resultat['ref_ext']) != ""){
                    $RefExt = trim($resultat['ref_ext']);
                }
                $CustomerId = NULL;
                if(trim($resultat['socid']) != ""){
                    $occurence2 = $em->getRepository(Customers::class)
                        ->findOneBy(array(
                            "dolid" => trim($resultat['socid']),
                            "origineid" => $OrigineId
                        ));
                    if($occurence2) {
                        $CustomerId = $occurence2->getId();
                    }
                }
                $State = NULL;
                if(trim($resultat['statut']) != ""){
                    $State = trim($resultat['statut']);
                }
                $Date = NULL;
                if(trim($resultat['date_creation']) != ""){
                    $Date = new DateTimeImmutable(date('Y-m-d', trim($resultat['date_creation'])));
                }
                $DateUpdate = NULL;
                if(trim($resultat['date_modification']) != ""){
                    $DateUpdate = new DateTimeImmutable(date('Y-m-d H:m:s', trim($resultat['date_modification'])));
                }
                $TotalHT = NULL;
                if(trim($resultat['total_ht']) != ""){
                    $TotalHT = trim($resultat['total_ht']);
                }
                $TotalTVA = NULL;
                if(trim($resultat['total_tva']) != ""){
                    $TotalTVA = trim($resultat['total_tva']);
                }
                $TotalTTC = NULL;
                if(trim($resultat['total_ttc']) != ""){
                    $TotalTTC = trim($resultat['total_ttc']);
                }
                $NotePublic = NULL;
                if(trim($resultat['note_public']) != ""){
                    $NotePublic = trim($resultat['note_public']);
                }
                $NotePrive = NULL;
                if(trim($resultat['note_private']) != ""){
                    $NotePrive = trim($resultat['note_private']);
                }

                $occurence = $em->getRepository(Contracts::class)
                    ->findOneBy(array(
                        "dolid" => $Id,
                        "origineid" => $OrigineId
                    ));

                if(is_null($occurence)) {
                    $tp_entity = new Contracts();
                    $tp_entity
                        ->setReferencebr($ReferenceBr)
                        ->setReference($Reference)
                        ->setRefext($RefExt)
                        ->setReference($Reference)
                        ->setCustomerid($em->getReference('App\Entity\Customers', $CustomerId))
                        ->setState($State)
                        ->setDate($Date)
                        ->setTotalht($TotalHT)
                        ->setTotaltva($TotalTVA)
                        ->setTotalttc($TotalTTC)
                        ->setNotepublic($NotePublic)
                        ->setNoteprive($NotePrive)
                        ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                        ->setDolid($Id);
                    $em->persist($tp_entity);
                }else{
                    $occurence
                        ->setReferencebr($ReferenceBr)
                        ->setReference($Reference)
                        ->setRefext($RefExt)
                        ->setReference($Reference)
                        ->setCustomerid($em->getReference('App\Entity\Customers', $CustomerId))
                        ->setState($State)
                        ->setDate($Date)
                        ->setTotalht($TotalHT)
                        ->setTotaltva($TotalTVA)
                        ->setTotalttc($TotalTTC)
                        ->setNotepublic($NotePublic)
                        ->setNoteprive($NotePrive)
                        ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                        ->setDolid($Id);
                    $em->persist($occurence);
                }
                $em->flush();
            }
        }
    }
}