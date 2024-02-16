<?php

namespace App\Entity;

use App\Entity\Contracts;
use App\Entity\Invoices;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\LinkContractInvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LinkContractInvoiceRepository::class)]
#[ApiResource]
class LinkContractInvoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'linkContractInvoices')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type(Contracts::class)]
    private ?Contracts $contractid = null;

    #[ORM\ManyToOne(inversedBy: 'linkContractInvoices')]
    #[Assert\Type(Invoices::class)]
    private ?Invoices $invoiceid = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractid(): ?Contracts
    {
        return $this->contractid;
    }

    public function setContractid(?Contracts $contractid): static
    {
        $this->contractid = $contractid;

        return $this;
    }

    public function getInvoiceid(): ?Invoices
    {
        return $this->invoiceid;
    }

    public function setInvoiceid(?Invoices $invoiceid): static
    {
        $this->invoiceid = $invoiceid;

        return $this;
    }


}
