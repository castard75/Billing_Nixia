<?php

namespace App\Controller;

use App\DTO\TelephoneDTO;
use App\Entity\Controle;
use App\Entity\Employees;
use App\Entity\Contracts;
use App\Entity\Cdr;
use App\Entity\Customers;
use App\Entity\Telephone;
use App\Entity\History;
use App\Entity\Invoicesitems;
use App\Form\TelephoneDTOType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Annotation\Security;
use Dompdf\Dompdf;

class HomeController extends AbstractController
{
    public function __construct(  EntityManagerInterface $em, ){


       $this->em = $em;

       }

    #[Route('/home', name: 'app_home')]

    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        dump($user);
        /*############################# GESTION HISTORY  ############################# */

             $today = new \DateTime();
             $todayFormatted = $today->format('Y-m-d'); 

             $history = $this->em->getRepository(History::class)->createQueryBuilder('h')
                        ->where('h.createdAt >= :today') // Utilisez >= pour inclure les données d'aujourd'hui et ultérieures
                        ->setParameter('today', $todayFormatted)
                        ->getQuery()
                        ->getResult();
       
        /*############################# GESTION INVOICESITEMS  ############################# */

                          $ListeInvoice = $entityManager->getRepository(Invoicesitems::class);                 
                          $query = $entityManager->createQuery(
                            'SELECT c
                            FROM App\Entity\Invoicesitems c
                            GROUP BY c.id
                            ORDER BY c.id ASC'
                        );
                        
                        $query->setMaxResults(20);               
                        $results = $query->getResult();
                        $invoiceQueryBuilder = $ListeInvoice->createQueryBuilder('i');
                        $invoiceQueryBuilder->select('COUNT (DISTINCT i.id) AS total');
                        $getInvoicesGenerated = $invoiceQueryBuilder->getQuery()->getResult();
                        

                         


        /*#############################  TOTAL TELEPHONES ############################# */

        $TelRepository = $entityManager->getRepository(Telephone::class);
        $TelQueryBuilder = $TelRepository->createQueryBuilder('t');
        $TelQueryBuilder->select('COUNT(DISTINCT t.name) AS num');
        $TotalNums = $TelQueryBuilder->getQuery()->getResult(); 

       /*#############################  TOTAL CONTRATS ############################# */

        $ContractRepository = $entityManager->getRepository(Contracts::class);
        $ContractsQueryBuilder =  $ContractRepository->createQueryBuilder('c');
        $ContractsQueryBuilder->select('COUNT (DISTINCT c.reference) AS ref');
        $resultContractsNumber = $ContractsQueryBuilder->getQuery()->getResult();

       /*#############################  TOTAL CDR  ############################# */

        $CdrRepository = $entityManager->getRepository(Cdr::class);
        $CdrQueryBuilder =  $CdrRepository->createQueryBuilder('c');
        $CdrQueryBuilder->select('COUNT (DISTINCT c.id) AS ref');
        $resultCdrTotal = $CdrQueryBuilder->getQuery()->getResult();

        /*############################# CONTRAT EN COURS ################################*/

        $getContractActivated =  $ContractsQueryBuilder->where('c.state = :stateValue')
        ->setParameter('stateValue', 1);
        $contractsActivated = $getContractActivated->getQuery()->getResult();

        /*############################# CONTRATS TERMINER ################################*/
        
        $getContractDesactivated = $ContractsQueryBuilder->where('c.state = :stateValue')
        ->setParameter('stateValue',0);
        $ContratDesactivated = $getContractDesactivated->getQuery()->getResult();

        /*############################# TOTAL CUSTOMERS ############################# */

         $CustomerRepository = $entityManager->getRepository(Customers::class);
         $CustomerQB = $CustomerRepository->createQueryBuilder('cm');
         $CustomerQB->select('COUNT (DISTINCT cm.dolid) AS customer');
         $resultCustomers = $CustomerQB->getQuery()->getResult();

       /*############################# RETURN  ############################# */

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'TotalContracts' => $resultContractsNumber[0]['ref'],
            'totalNum'=> $TotalNums[0]['num'],
            'TotalCustomers' => $resultCustomers[0]['customer'],
            'history' => $history,
            'results' => $results,
            'contractsActivated' => $contractsActivated[0]['ref'],
            'ContratDesactivated' => $ContratDesactivated[0]['ref'],
            'CdrTotal' => $resultCdrTotal[0]['ref'],
            'TotalInvoices' => $getInvoicesGenerated[0]['total']
          
        ]);
    }


    #[Route('/associate', name: 'app_associate')]
    public function associate(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
    /* Dans la boucle pour chaque telephone je crée un objet dto avec un numéro de telephone initialisé, pour crée un formulaire
    .Parcontre les contrats seront totalement retourné dans un Select ce qui permet de les liés à un numéros.
    j'appel la méthode createForm() pour crée le formulaire puis la soumission je cherche l'id du telephone et s'il est déja lié dans contrôle je met une date de fin dans le cas contraire j'initialise une nouvelle ligne dans la table.
    Quand la liaison à été crée avec succès je crée un évenement via la table History qui permet d'affiché dans le front un message dans la partie 'Activité récentes"
    */        


        $telephones = $entityManager->getRepository(Telephone::class)->findAll();
        $controlTab = $entityManager->getRepository(Controle::class);

        $forms = [];
        foreach ($telephones as $telephone) {

            $dto = (new TelephoneDTO())->setTelephone($telephone); 
            $form = $this->createForm(TelephoneDTOType::class, $dto);     
            $form->handleRequest($request); 

            if ($form->isSubmitted() && $form->isValid()) {
                $existingLink =  $controlTab->findOneBy(['telephoneid'=>$dto->getTelephone()],['startserviceat' => 'DESC']);
                
                 
                 if ($existingLink !== null) {
                    $existingLink->setOutserviceat(new \DateTime('now'));}
      

                if ($request->isXmlHttpRequest()) { // si traitement ajax success


                    $controle = (new Controle())
                        ->setTelephoneid($dto->getTelephone())
                        ->setContratid($dto->getContrat());
                    $entityManager->persist($controle);
                    $entityManager->flush();
                    $data = $serializer->serialize($controle, 'json');

                    //Gestion de l'historique
                    $history = (new History())  
                    ->setTitle("Assocation")
                    ->setDescription("Le numéro"." " . $dto->getTelephone() . " a été asscocié au client ". " " . $dto->getContrat()->getCustomerid()->getName() );
                    $entityManager->persist($history);
                    $entityManager->flush();

                    return new JsonResponse(['success' => true, 'data' => json_decode($data)]);

                }
            }else {
                if ($request->isXmlHttpRequest()) { // si erreur traitement ajax
                    $errors = [];
                    foreach ($form->getErrors(true) as $error) {
                        $errors[] = $error->getMessage();
                    }
                    return new JsonResponse(['success' => false, 'errors' => $errors], Response::HTTP_BAD_REQUEST);
                }
            }

            $forms[$telephone->getId()] = $form->createView(); //creation de la vue pour chaque tel

        }

        return $this->render('home/associate.html.twig', [
            'forms' => $forms,
            
        ]);
    }

    
    #[Route('/liaison', name: 'app_liaison')]
    public function liaison(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
       /* Un controller liaison à pour but d'afficher toute les liaisons crée histoire d'avoir une vue d'ensemble sur les liaisons éffectuées */
        $controls = $entityManager->getRepository(Controle::class)->findBy([], ['id' => 'DESC']);
        return $this->render('home/liaison.html.twig', [
            'controller_name' => 'HomeController',
            // 'form' => $form->createView(),
            'controls' => $controls,
        ]);
    }





}