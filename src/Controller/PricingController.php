<?php

namespace App\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Cdr;
use App\Entity\Contracts;
use App\Entity\Customers;
use App\Entity\LinkContractInvoice;
use App\Entity\Invoicesitems;
use App\Entity\Controle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Invoices;
use App\Services\InsertService;
use App\Entity\Coefficient;
use App\Events\eventInvoice;
use Symfony\Component\Security\Core\Security;


use DateTimeImmutable;

class PricingController extends AbstractController
{


    public function __construct(  EntityManagerInterface $em, InsertService $insertService,Security $security){


        $this->em = $em;
        $this->insertService = $insertService;
        $this->security = $security;
       }


    #[Route('/pricing', name: 'app_pricing')]
    public function index(): Response
    {
        $coefficient = $this->em->getRepository(Coefficient::class)->find(1);


        $cdrRepository = $this->em->getRepository(Cdr::class);
        $qb = $cdrRepository->createQueryBuilder('c');

        $qb->select('c.caller', 'SUM(c.price) AS total_price')
            ->where($qb->expr()->like('c.caller', ':prefix'))
            ->setParameter('prefix', '+%')
            ->groupBy('c.caller');
        
        $resultWithPrefix = $qb->getQuery()->getResult();

        /* Numéros sans prefixe */
        $NumWithoutPrefix = $cdrRepository->createQueryBuilder('c');

        $NumWithoutPrefix->select('c.caller', 'SUM(c.price) AS total_price')
            ->where($NumWithoutPrefix->expr()->notlike('c.caller', ':prefix'))
            ->setParameter('prefix', '+%')
            ->groupBy('c.caller');
        
        $resultWithoutPrefix = $NumWithoutPrefix->getQuery()->getResult();
       

        $ListeControl = $this->em->getRepository(Controle::class)->findAll();

        $tabControl = [];
        foreach($ListeControl as $data){
          $telephoneId = $data->getTelephoneid();
          $number = $data->getTelephoneid();
          $contratName = $data->getContratid();
          $contratId = $data->getContratid()->getId();
       

       $tabControl[] = [
        'telephoneId' => $telephoneId,
          'contratid' => $contratId,
          'contratName' => $contratName,
          
          'number' => $number->getId()] ;
          

        }

        return $this->render('pricing/index.html.twig', [
            'controller_name' => 'PricingController',
            'controlTab' => $tabControl,
            'coefficient'=> 'salut',
        ]);
    }




    #[Route('/getPrice', name: 'app_getPrice',  methods: ['POST'])]
    public function makeTotal(Request $request ,EntityManagerInterface $entity): Response
    {
        $controlRepository = $this->em->getRepository(Controle::class);
        $coefficient = $this->em->getRepository(Coefficient::class)->find(1);
        $cdrRepository = $this->em->getRepository(Cdr::class);
        $contractRepository = $this->em->getRepository(Contracts::class);

        //Data du pricing
        $jsonData = json_decode($request->getContent(), true);
        $resultats = array();
      
        //---------------------------Gestion date-------------------------------//
        $today = new \DateTime();
        $firstDay = $today->modify('first day of this month');
        $firstDayToString = $firstDay->format('Y-m-d');

        $lastMonth = $today->modify('last month');
        $lastMonthToString = $lastMonth->format('Y-m-d');
      
        $lastDayOfLastMonth = $lastMonth->format('Y-m-t');
        $objForInvoiceItem = [];


        foreach($jsonData as $val){
            
            $caller = $val["telephoneChecked"];
            $contratChecked = $val['contratChecked'];
            $telId = $val['idNumber'];
            $contratname= $val['name'];

            //-------------Recuperation des lignes selectionnées dans  la table controle-------------//
            $findLine = $controlRepository->findBy(['telephoneid' => $telId, 'contratid'=>$contratChecked]);


     foreach($findLine as $line){
 
            $findCaller = $cdrRepository->findBy(["caller" => $caller]); //$caller à mettre
          
            $callerOutDate = $line->getOutserviceat();

            //Calcul pour les contrats terminer

        if(isset($callerOutDate)){ 

            $callerOutDate->modify('+1 day');
            $formattedDate = $callerOutDate->format('Y-m-d');

            ////-------------------récupération des communications--------------------////
            foreach ($findCaller as $cdr) {
              
            $sipTrunk = $cdr->getSipTrunk();
            $idObj = $cdr->getId();
            $queryBuilderPrice = $cdrRepository->createQueryBuilder('c');

           //Requête filtrage entre date de début de mois et fin de contrat

            $queryBuilderPrice->where('c.sipTrunk = :sipTrunk')
            ->setParameter('sipTrunk', $sipTrunk)
            ->andWhere($queryBuilderPrice->expr()->between('c.dateAt', ':startDate', ':endDate'))
            ->setParameter('startDate', $lastMonthToString)
            ->setParameter('endDate', $callerOutDate)
            ->select('SUM(c.price) as totalPrice');
        
   
             $findPrice = $queryBuilderPrice->getQuery()->getResult();
           
             $totalPrice = $findPrice[0]['totalPrice'];
             dump($totalPrice);
          
             $resultats[] = array('total'=>$totalPrice, 'caller'=>$caller,'telId'=>$telId,'contratId'=>$contratChecked,'contrat'=>$contratname, 'coefficient' => $coefficient);
            
            }
           

 
            $customer = $this->em->getRepository(Customers::class)->find($contratChecked);
         
        

        } 
                //Calcul pour les contrats en cours
        else {

            foreach ($findCaller as $cdr) {
 
             
                $sipTrunk = $cdr->getSipTrunk();
                $queryBuilder = $cdrRepository->createQueryBuilder('c');
    
    
            $queryBuilder->where('c.sipTrunk = :sipTrunk')
                ->setParameter('sipTrunk', $sipTrunk)
                ->andWhere($queryBuilder->expr()->between('c.dateAt', ':startDate', ':endDate'))
                ->setParameter('startDate', $lastMonthToString)
                ->setParameter('endDate', $lastDayOfLastMonth)
                ->select('SUM(c.price) as totalPrice');
            
       
            $findPrice = $queryBuilder->getQuery()->getResult();
            $totalPrice = $findPrice[0]['totalPrice'];
            dump($totalPrice);
            $resultats[] = array('total'=>$totalPrice, 'caller'=>$caller,'telId'=>$telId,'contratId'=>$contratChecked, 'contrat'=> $contratname, 'coefficient' => $coefficient);

            }



            
        }
           
       }
     
    
    }

        //---------Suppression des doublons généré par la boucle----------//
        $uniqueArray = array_map("unserialize", array_unique(array_map("serialize", $resultats)));


        return new JsonResponse(['success' => true, 'datas' => $uniqueArray]);
 
    }





    ////-------------------------INSERTION BASE DE DONNEES--------------------------////

    #[Route('/postInvoices', name: 'app_postInvoices',  methods: ['POST'])]   
    public function insert(Request $request ,EntityManagerInterface $entity,EventDispatcherInterface $eventDispatcher): Response {

            $response = new Response();
      
 
            $jsonData = json_decode($request->getContent(), true);
            $dataToSend = array();
            // $this->insertService->createInvoice($jsonData);
        
             $injection = $this->insertService->createInvoice($jsonData); //Stockage de la facture en Bdd 

           return new JsonResponse(['success' => true]);


          }



       }