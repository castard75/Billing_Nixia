<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Customers;
use App\Entity\Contracts;
use Doctrine\ORM\EntityManagerInterface;

class TiersPageController extends AbstractController
{
    #[Route('/tiers', name: 'app_tiers')]
    public function index(EntityManagerInterface $entityManager): Response
    { 
        
        $ListTiers = $entityManager->getRepository(Customers::class)->findAll();
        $ListeContracts = $entityManager->getRepository(Contracts::class)->findAll();
    
        
        return $this->render('tiers_page/index.html.twig', [
            'controller_name' => 'ContratController',
            'ListeContracts' => $ListeContracts,
            'ListTiers' => $ListTiers,
        ]);
    }
    
    #[Route('/tiers-{id}', name: 'app_tiers_detail')]
    public function detail(EntityManagerInterface  $entityManager, int $id) : Response{
        $Tiers = $entityManager->getRepository(Customers::class)->find($id);
        if (!$Tiers) {
            throw $this->createNotFoundException(
                'No tiers found for id ' . $id
            );
        }
        return $this->render('tiers_page/detail.html.twig',[
            'controller_name' => 'ContratController',
            'contenu_titre' => $Tiers->getReference() . " / " . $Tiers->getName(),
            'contenu_id' => $Tiers->getId(),
            'Nametiers' => $Tiers->getName(),
            'OriginTiers' => $Tiers->getOrigineid()->getLabel(),
            'StatusTiers' => $Tiers->getStatus(),
            'AddressTiers' => $Tiers->getAddress(),
            'EmailTier'=> $Tiers->getEmail(),
            'NameCity' => $Tiers->getNamecity(),
            

        ]);


    }



}
