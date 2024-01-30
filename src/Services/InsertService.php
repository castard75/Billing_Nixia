<?php 

namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Invoices;
use App\Entity\Invoicesitems;
use App\Entity\LinkContractInvoice;
use App\Entity\Customers;
use Symfony\Component\Security\Core\Security;

class InsertService {

     private $tabOfData;
     private $security;

     public function __construct(EntityManagerInterface $entity,Security $security) {

     
         $this->em = $entity;
         $this->security = $security;

     }


     public function createInvoice(array $jsonData){


        foreach($jsonData as $datas){
           

            $caller = $datas["caller"];
            $contratId = $datas['contratId'];
            $total = $datas['total'];
       
            $entier = intval($total);
            $customer = $this->em->getRepository(Customers::class)->find($contratId);

            $dataToSend[] = array($caller,$contratId);
            
            $invoice = (new Invoices())
            ->setCustomerid($customer)
           
            ->setOrigineid($this->em->getReference('App\Entity\Myconnectors', 1))
            ->setTotalttc($entier);
            
            $this->em->persist($invoice);
            
            $this->em->flush();
            
            $invoiceId = $invoice->getId();
            
            $invoiceitem = (new Invoicesitems())
            ->setInvoiceid($invoice)
            ->setQuantity(1)        
            ->setReference($caller)
            ->setHt($total)
            ->setMarge(0.1)
            ->setHtachat(0.5);
            
            $this->em->persist($invoiceitem);
             $this->em->flush();
            
            // $linkContrat = (new LinkContractInvoice())
            // ->setContractid($contratId)
            // ->setInvoiceid($invoiceId);
            
           
            
            // $this->em->persist($linkContrat);
            $this->em->flush();


           }

     }


}