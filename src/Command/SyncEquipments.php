<?php

namespace App\Command;

use App\Entity\Contracts;
use App\Entity\Customers;
use App\Entity\Customerssites;
use App\Entity\EquipementCharge;
use App\Entity\EquipementEntrainement;
use App\Entity\EquipementMarque;
use App\Entity\EquipementType;
use App\Entity\Equipments;
use App\Entity\Equipmentsextras;
use App\Entity\Myconnectors;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:syncequipments',
)]
class SyncEquipments extends Command
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
            ->setDescription('Synchronistaion des equipments')
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

        $RequeteApi = $this->ClientHTTP->request("GET", $UrlApi."/registreapi/equipements?sortfield=t.rowid&sortorder=ASC&limit=100000");
        if($RequeteApi->getStatusCode() == 200){
            $content = json_decode($RequeteApi->getContent(), true);

            foreach($content as $resultat)
            {
                $Id = trim($resultat['id']);
                $Reference = NULL;
                if(trim($resultat['ref']) != ""){
                    $Reference = trim($resultat['ref']);
                }
                $Label = NULL;
                if(trim($resultat['label']) != ""){
                    $Label = trim($resultat['label']);
                }
                $CustomerId = NULL;
                $CustomerId2 = NULL;
                if(trim($resultat['fk_soc']) != ""){
                    $occurence2 = $em->getRepository(Customers::class)
                        ->findOneBy(array(
                            "dolid" => trim($resultat['fk_soc']),
                            "origineid" => $OrigineId
                        ));
                    if($occurence2) {
                        $CustomerId2 = $occurence2->getId();
                        $CustomerId = $em->getReference('App\Entity\Customers', $occurence2->getId());
                    }
                }
                $State = NULL;
                if(trim($resultat['status']) != ""){
                    $State = trim($resultat['status']);
                }
                $Date = NULL;
                if(trim($resultat['date_creation']) != ""){
                    $Date = new DateTimeImmutable(date('Y-m-d', trim($resultat['date_creation'])));
                }
                $DateUpdate = NULL;
                if(trim($resultat['date_modification']) != ""){
                    $DateUpdate = new DateTimeImmutable(date('Y-m-d H:m:s', trim($resultat['tms'])));
                }

                $SiteId = NULL;
                $occurenceInter = $em->getRepository(Customerssites::class)
                    ->findOneBy(array(
                        "clientid" => $CustomerId,
                        "label" => $Label
                    ));
                if(!$occurenceInter) {
                    $tp_entity2 = new Customerssites();
                    $tp_entity2
                        ->setLabel($Label)
                        ->setClientid($CustomerId);
                    $em->persist($tp_entity2);
                    $em->flush();

                    $occurenceInter2 = $em->getRepository(Customerssites::class)
                        ->findOneBy(array(
                            "clientid" => $CustomerId,
                            "label" => $Label
                        ));
                    $SiteId = $em->getReference('App\Entity\Customerssites', $occurenceInter2->getId());
                }else{
                    $SiteId = $em->getReference('App\Entity\Customerssites', $occurenceInter->getId());
                }

                $TypeId = NULL;
                if(isset($resultat['array_options']['options_type'])) {
                    if (trim($resultat['array_options']['options_type']) != "") {
                        $occurenceInter = $em->getRepository(EquipementType::class)
                            ->findOneBy(array(
                                "id" => $resultat['array_options']['options_type']
                            ));
                        if ($occurenceInter) {
                            $TypeId = $em->getReference('App\Entity\EquipementType', $resultat['array_options']['options_type']);
                        }
                    }
                }

                $MarqueId = NULL;
                if(isset($resultat['array_options']['options_marque'])) {
                    if (trim($resultat['array_options']['options_marque']) != "") {
                        $occurenceInter = $em->getRepository(EquipementMarque::class)
                            ->findOneBy(array(
                                "id" => $resultat['array_options']['options_marque']
                            ));
                        if ($occurenceInter) {
                            $MarqueId = $em->getReference('App\Entity\EquipementMarque', $resultat['array_options']['options_marque']);
                        }
                    }
                }

                $ChargeId = NULL;
                if(isset($resultat['array_options']['options_chargekg'])) {
                    if (trim($resultat['array_options']['options_chargekg']) != "") {
                        $occurenceInter = $em->getRepository(EquipementCharge::class)
                            ->findOneBy(array(
                                "id" => $resultat['array_options']['options_chargekg']
                            ));
                        if ($occurenceInter) {
                            $ChargeId = $em->getReference('App\Entity\EquipementCharge', $resultat['array_options']['options_chargekg']);
                        }
                    }
                }

                $EntrainementId = NULL;
                if(isset($resultat['array_options']['options_entrainement'])) {
                    if (trim($resultat['array_options']['options_entrainement']) != "") {
                        $occurenceInter = $em->getRepository(EquipementEntrainement::class)
                            ->findOneBy(array(
                                "id" => $resultat['array_options']['options_chargekg']
                            ));
                        if ($occurenceInter) {
                            $EntrainementId = $em->getReference('App\Entity\EquipementEntrainement', $resultat['array_options']['options_entrainement']);
                        }
                    }
                }

                $NiveauId = NULL;
                if(isset($resultat['array_options']['options_niveau'])) {
                    if (trim($resultat['array_options']['options_niveau']) != "") {
                        $NiveauId = trim($resultat['array_options']['options_niveau']);
                    }
                }

                $ContractId = NULL;
                $IdContrat = NULL;
                $Nbr = 0;
                if($CustomerId2 != "") {
                    $ListeContrat = $this->entityManager->getRepository(Contracts::class)->createQueryBuilder('u')->where('u.customerid = ' . $CustomerId2)->getQuery()->execute();
                    foreach ($ListeContrat as $Val) {
                        $Nbr++;
                        $IdContrat = $Val->getId();
                    }
                    if ($Nbr == 1) {
                        $ContractId = $em->getReference('App\Entity\Contracts', $IdContrat);
                    }
                }

                $occurence = $em->getRepository(Equipments::class)
                    ->findOneBy(array(
                        "dolid" => $Id,
                        "origineid" => $OrigineId
                    ));

                if(is_null($occurence)) {
                    $tp_entity = new Equipments();
                    $tp_entity
                        ->setReference($Reference)
                        ->setName($Label)
                        ->setStatus($State)
                        ->setTypeid($TypeId)
                        ->setMarqueid($MarqueId)
                        ->setChargeid($ChargeId)
                        ->setNiveau($NiveauId)
                        ->setEntrainementid($EntrainementId)
                        ->setCustomerid($CustomerId)
                        ->setContratid($ContractId)
                        ->setCreatedat($Date)
                        ->setUpdatedat($DateUpdate)
                        ->setSiteid($SiteId)
                        ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                        ->setDolid($Id);
                    $em->persist($tp_entity);
                }else{
                    $occurence
                        ->setReference($Reference)
                        ->setName($Label)
                        ->setStatus($State)
                        ->setTypeid($TypeId)
                        ->setMarqueid($MarqueId)
                        ->setChargeid($ChargeId)
                        ->setEntrainementid($EntrainementId)
                        ->setNiveau($NiveauId)
                        ->setCustomerid($CustomerId)
                        ->setContratid($ContractId)
                        ->setCreatedat($Date)
                        ->setUpdatedat($DateUpdate)
                        ->setSiteid($SiteId)
                        ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                        ->setDolid($Id);
                    $em->persist($occurence);
                }
                $em->flush();

                $occurence2 = $em->getRepository(Equipments::class)
                    ->findOneBy(array(
                        "dolid" => $Id,
                        "origineid" => $OrigineId
                    ));
                if(!is_null($occurence2)) {
                    $Id2 = $occurence2->getId();
                    if(isset($resultat["array_options"])){
                        foreach ($resultat["array_options"] as $Tab5 => $Tab6){
                            $NameOption = $Tab5;
                            $ValeurOption = $Tab6;
                            $occurence3 = $em->getRepository(Equipmentsextras::class)
                                ->findOneBy(array(
                                    "code" => $NameOption,
                                    "equipmentid" => $Id2
                                ));
                            if(is_null($occurence3)) {
                                $tp_entity = new Equipmentsextras();
                                $tp_entity
                                    ->setCode($NameOption)
                                    ->setValue($ValeurOption)
                                    ->setEquipmentid($em->getReference('App\Entity\Equipments', $Id2))
                                    ->setCreatedat(NULL)
                                    ->setUpdatedat(NULL);
                                $em->persist($tp_entity);
                            }else{
                                $occurence3
                                    ->setCode($NameOption)
                                    ->setValue($ValeurOption)
                                    ->setEquipmentid($em->getReference('App\Entity\Equipments', $Id2));
                                $em->persist($occurence3);
                            }
                            $em->flush();
                        }
                    }
                }
            }
        }
    }
}