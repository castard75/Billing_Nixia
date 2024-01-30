<?php

namespace App\Command;

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
    name: 'app:synccustomers',
)]
class SyncCustomers extends Command
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
            ->setDescription('Synchronistaion des customers')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ListeConnector = $this->entityManager->getRepository(Myconnectors::class)->createQueryBuilder('u')->where('u.url IS NOT NULL')->getQuery()->execute();
        foreach ($ListeConnector as $Val) {
            //Récupere les infos Doli
            $OrigineId = $Val->getId();
            $UrlApi = $Val->getUrl();
            $TokenApi = $Val->getLogin();

            $this->recupererListeClient($OrigineId, $UrlApi, $TokenApi);
        }

        return Command::SUCCESS;
    }

    private function recupererListeClient($OrigineId, $UrlApi, $TokenApi)
    {
        $em = $this->entityManager;

        $this->ClientHTTP = HttpClient::create()->withOptions([
            'headers' => [
                'Accept' => 'application/json',
                'DOLAPIKEY' => $TokenApi
            ]
        ]);

        $RequeteApi = $this->ClientHTTP->request("GET", $UrlApi . "/thirdparties?sortfield=t.rowid&sortorder=ASC&limit=100000");
        if ($RequeteApi->getStatusCode() == 200) {
            $content = json_decode($RequeteApi->getContent(), true);

            foreach ($content as $resultat) {
                $Id = $resultat['ref'];
                $Date = new DateTimeImmutable(date('Y-m-d H:m:s', $resultat['date_creation']));
                $DateUpdate = new DateTimeImmutable(date('Y-m-d H:m:s', $resultat['date_modification']));
                $Status = $resultat['status'];
                $Civ = NULL;
                $Name = $resultat['name'];
                $Firstname = NULL;
                if (trim($resultat['name_alias']) != "") {
                    $Firstname = trim($resultat['name_alias']);
                }
                $CodeCompta = NULL;
                if (trim($resultat['code_compta_client']) != "") {
                    $CodeCompta = trim($resultat['code_compta_client']);
                }
                $Siren = NULL;
                if (trim($resultat['idprof1']) != "") {
                    $Siren = trim($resultat['idprof1']);
                }
                $Siret = NULL;
                if (trim($resultat['idprof2']) != "") {
                    $Siret = trim($resultat['idprof2']);
                }
                $Address = $resultat['address'];
                $AdditionalAddress = NULL;
                $Email = $resultat['email'];
                $FixPhone = $resultat['phone'];
                $PriceLevel = $resultat['price_level'];
                $MobilePhone = NULL;
                $PostCode = $resultat['zip'];
                $NameCity = $resultat['town'];
                $CityId = NULL;
                $State = $resultat['status'];
                $CountryId = NULL;
                $CustomerTypeId = NULL;
                $ConditionReglement = $resultat['cond_reglement_id'];
                $ModeReglement = $resultat['mode_reglement_id'];
                $CustomerState = $resultat['client'];
                $SupplierState = $resultat['fournisseur'];
                $Reference = NULL;
                $ReferenceSupplier = NULL;
                if ($CustomerState == 1 || $CustomerState == 3) {
                    $Reference = $resultat['code_client'];
                }
                if ($SupplierState == 1) {
                    $ReferenceSupplier = $resultat['code_fournisseur'];
                } elseif ($CustomerState == 2) {
                    $CustomerState = 1;
                    $Reference = $resultat['code_client'];
                }

                $occurence = $em->getRepository(Customers::class)
                    ->findOneBy(array(
                        "dolid" => $Id,
                        "origineid" => $OrigineId
                    ));

                if (is_null($occurence)) {
                    $tp_entity = new Customers();
                    $tp_entity
                        ->setCivility($Civ)
                        ->setName($Name)
                        ->setFirstname($Firstname)
                        ->setReference($Reference)
                        ->setReferencesupplier($ReferenceSupplier)
                        ->setSiren($Siren)
                        ->setSiret($Siret)
                        ->setAddress($Address)
                        ->setAdditionaladdress($AdditionalAddress)
                        ->setEmail($Email)
                        ->setFixphone($FixPhone)
                        ->setMobilephone($MobilePhone)
                        ->setCityid($CityId)
                        ->setPostcode($PostCode)
                        ->setNamecity($NameCity)
                        ->setCountryid($CountryId)
                        ->setCustomertypeid($CustomerTypeId)
                        ->setConditionreglement($ConditionReglement)
                        ->setModereglement($ModeReglement)
                        ->setStatus($Status)
                        ->setState($State)
                        ->setCodecompta($CodeCompta)
                        ->setCreatedat($Date)
                        ->setUpdatedat($DateUpdate)
                        ->setCustomerstate($CustomerState)
                        ->setSupplierstate($SupplierState)
                        ->setPricelevel($PriceLevel)
                        ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                        ->setDolid($Id);
                    $em->persist($tp_entity);
                } else {
                    $occurence
                        ->setCivility($Civ)
                        ->setName($Name)
                        ->setFirstname($Firstname)
                        ->setReference($Reference)
                        ->setReferencesupplier($ReferenceSupplier)
                        ->setSiren($Siren)
                        ->setSiret($Siret)
                        ->setAddress($Address)
                        ->setAdditionaladdress($AdditionalAddress)
                        ->setEmail($Email)
                        ->setFixphone($FixPhone)
                        ->setMobilephone($MobilePhone)
                        ->setCityid($CityId)
                        ->setPostcode($PostCode)
                        ->setNamecity($NameCity)
                        ->setCountryid($CountryId)
                        ->setCustomertypeid($CustomerTypeId)
                        ->setConditionreglement($ConditionReglement)
                        ->setModereglement($ModeReglement)
                        ->setStatus($Status)
                        ->setState($State)
                        ->setCodecompta($CodeCompta)
                        ->setCreatedat($Date)
                        ->setUpdatedat($DateUpdate)
                        ->setCustomerstate($CustomerState)
                        ->setSupplierstate($SupplierState)
                        ->setPricelevel($PriceLevel)
                        ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                        ->setDolid($Id);
                    $em->persist($occurence);
                }
                $em->flush();
            }
        }
    }
}
