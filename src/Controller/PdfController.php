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
        $customer = $invoice->getInvoiceid()->getCustomerid();
        $customerAddress =  $customer->getAddress();
        $customerName = $customer->getName();
        $customerEmail = $customer->getEmail();
        $customerTotal = $invoice->getHt();
        $dateInvoice = $invoice->getCreatedat();
        $taxe = 25.3;

        $data = [
            // 'imageSrc'  => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/profile.png'),
            'name'         => $customerName,
            'address'      => $customerAddress,
            'mobileNumber' => $ref ,
            'email'        => $customerEmail,
            'taxe' => $taxe,
            'total' => $customerTotal,
            'dateInvoice' => $dateInvoice,          
            'logo' => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/assets/img/nixia.png'),
        ];

        $html =  $this->renderView('pdf_generator/index.html.twig', [ "data" => $data]);
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

    private function imageToBase64($path)
    {
        if (file_exists($path)) {
            $data = file_get_contents($path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            $base64 = null;
        }
        return $base64;
    }

    

}
