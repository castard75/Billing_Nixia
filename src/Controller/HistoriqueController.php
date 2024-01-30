<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Invoices;
use App\Entity\Invoicesitems;

class HistoriqueController extends AbstractController
{

    public function __construct(EntityManagerInterface $em){
      $this->em = $em;

    }

    #[Route('/historique', name: 'app_historique')]
    public function index(): Response
    { 
               $invoicesTab = $this->getInvoices();
               $invoicesItemTab = $this->getInvoicesItems();

        return $this->render('historique/index.html.twig', [
            'controller_name' => 'Historique',
            'invoices' => $invoicesTab,
            'invoicesitems' => $invoicesItemTab 
        ]);
    }


    public function getInvoices() : array{
        $repository = $this->em->getRepository(Invoices::class);

         $result = $repository->findAll();
          dump($result);
           return $result;

    }

    public function getInvoicesItems() : array {

       $repoItems = $this->em->getRepository(Invoicesitems::class);
       $resultItem = $repoItems->findAll();
       return $resultItem;

    }
}
