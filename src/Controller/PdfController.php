<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Invoicesitems;
use App\Entity\Customers;
use App\Entity\Contracts;
use App\Services\pdfService;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;



class PdfController extends AbstractController
{
    #[Route('/pdf/generator-{id}', name: 'app_pdf_generator')]
    public function index(EntityManagerInterface $em,int $id): Response
    {
        $invoice = $em->getRepository(Invoicesitems::class)->find($id);
       


        if (!$invoice) {
            throw $this->createNotFoundException('Invoice not found');
        }
        $ref =  $invoice ->getReference();

        $data = [
            // 'imageSrc'  => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/profile.png'),
            'name'         => 'John Doe',
            'address'      => 'USA',
            'mobileNumber' => $ref ,
            'email'        => 'john.doe@email.com'
        ];

        $html =  $this->renderView('pdf_generator/index.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
         
        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    

}
