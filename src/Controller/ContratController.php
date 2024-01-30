<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contracts;
use App\Entity\Customers;
use Doctrine\ORM\EntityManagerInterface;

class ContratController extends AbstractController
{
    #[Route('/contrats', name: 'app_contrats')]
    public function index(EntityManagerInterface $entityManager): Response
    { 
        
        $ListTiers = $entityManager->getRepository(Customers::class)->findAll();
        $ListeContracts = $entityManager->getRepository(Contracts::class)->findAll();
    
        
        return $this->render('contrat/index.html.twig', [
            'controller_name' => 'ContratController',
            'ListeContracts' => $ListeContracts,
            'ListTiers' => $ListTiers,
        ]);
    }
}
