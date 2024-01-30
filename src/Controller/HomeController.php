<?php

namespace App\Controller;

use App\DTO\TelephoneDTO;
use App\Entity\Controle;
use App\Entity\Employees;
use App\Entity\Contracts;
use App\Entity\Customers;
use App\Entity\Telephone;
use App\Entity\History;
use App\Entity\Invoicesitems;
use App\Form\ContactLinkingFormType;
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

class HomeController extends AbstractController
{
    public function __construct(  EntityManagerInterface $em, ){


       $this->em = $em;

       }

    #[Route('/home', name: 'app_home')]

    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
                    //GESTION History
             $today = new \DateTime();
             $todayFormatted = $today->format('Y-m-d'); // Format de la base de données

             $history = $this->em->getRepository(History::class)->createQueryBuilder('h')
                        ->where('h.createdAt >= :today') // Utilisez >= pour inclure les données d'aujourd'hui et ultérieures
                        ->setParameter('today', $todayFormatted)
                        ->getQuery()
                        ->getResult();
       
                          //GESTION CDR
                          $ListeInvoice = $entityManager->getRepository(Invoicesitems::class);
                                       
                          $query = $entityManager->createQuery(
                            'SELECT c
                            FROM App\Entity\Invoicesitems c
                            GROUP BY c.id
                            ORDER BY c.id ASC'
                        );
                        
                        $query->setMaxResults(20);
                        
                        // Exécution de la requête
                        $results = $query->getResult();
                         

           

        /*Gestion total tel*/
        $TelRepository = $entityManager->getRepository(Telephone::class);
        $TelQueryBuilder = $TelRepository->createQueryBuilder('t');
        $TelQueryBuilder->select('COUNT(DISTINCT t.name) AS num');
        $TotalNums = $TelQueryBuilder->getQuery()->getResult(); 

       /*Gestion total contrats*/
        $ContractRepository = $entityManager->getRepository(Contracts::class);
        $ContractsQueryBuilder =  $ContractRepository->createQueryBuilder('c');
        $ContractsQueryBuilder->select('COUNT (DISTINCT c.reference) AS ref');
        $resultContractsNumber = $ContractsQueryBuilder->getQuery()->getResult();
      

        /*Gestion total customers */
         $CustomerRepository = $entityManager->getRepository(Customers::class);
         $CustomerQB = $CustomerRepository->createQueryBuilder('cm');
         $CustomerQB->select('COUNT (DISTINCT cm.dolid) AS customer');
         $resultCustomers = $CustomerQB->getQuery()->getResult();

        // Le bouton dans votre template appelle getData lorsque cliqué
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'TotalContracts' => $resultContractsNumber[0]['ref'],
            'totalNum'=> $TotalNums[0]['num'],
            'TotalCustomers' => $resultCustomers[0]['customer'],
            'history' => $history,
            'results' => $results
          
        ]);
    }


    #[Route('/associate', name: 'app_associate')]
    public function associate(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
 


        $telephones = $entityManager->getRepository(Telephone::class)->findAll();
        $controlTab = $entityManager->getRepository(Controle::class);

        $forms = [];
        foreach ($telephones as $telephone) {
            //Pour chaque telephone je crée un objet dto avec un numéro de telephone initialisé, pour crée le formulaire.
            $dto = (new TelephoneDTO())->setTelephone($telephone);         //les telephone sont mis a jour, les contrats seront bouclés depuis TelephoneDTOType
            $form = $this->createForm(TelephoneDTOType::class, $dto);     //Creation des formulaire a partir de l'objet dto
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
       
        $controls = $entityManager->getRepository(Controle::class)->findBy([], ['id' => 'DESC']);
        return $this->render('home/liaison.html.twig', [
            'controller_name' => 'HomeController',
            // 'form' => $form->createView(),
            'controls' => $controls,
        ]);
    }



}