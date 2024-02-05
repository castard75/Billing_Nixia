<?php

namespace App\Services;
use Dompdf\Dompdf;
use Dompdf\Options;


class pdfService{

private $domPdf;

public function __construct(){

    $this->domPdf = new Dompdf();

    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont','Garamond');
    $this->domPdf->setOptions($pdfOptions);

    

 }


 public function showPdf($html){

        $this->domPdf->loadHtml($html);
        $this->domPdf->setPaper('A4', 'landscape');
        $this->domPdf->stream( "details.pdf",[

            'Attachement' =>false
        ]);

 }

 public function generatePdf($html){

        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->output();


 }



}