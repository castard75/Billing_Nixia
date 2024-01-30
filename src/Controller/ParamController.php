<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Coefficient;

use Symfony\Component\HttpFoundation\Request;

class ParamController extends AbstractController
{


    #[Route('/param', name: 'app_param')]
    public function index(): Response
    {

        return $this->render('param/index.html.twig', [
            'controller_name' => 'ParamController',
        ]);
    }


    #[Route('/postCoefficient', name: 'app_postCoef', methods:['POST'])]  
    public function sendCoefficient(Request $request ,EntityManagerInterface $em): Response {
        $jsonData = json_decode($request->getContent(), true);
        
      $repositoryCoef = $em->getRepository(Coefficient::class);
      $coefficientObj =( new Coefficient())
      ->setCoefficient($jsonData);
      
        $em->persist($coefficientObj);
        $em->flush();
          return new JsonResponse(['success' => true, 'data' => $jsonData]);


          }
}
