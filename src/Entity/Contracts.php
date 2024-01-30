<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ContractsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractsRepository::class)]
#[ApiResource]
class Contracts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $referencebr = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $refext = null;

    #[ORM\Column(nullable: true)]
    private ?int $dolid = null;

    #[ORM\Column(nullable: true)]
    private ?int $state = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalht = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalttc = null;

    #[ORM\Column(nullable: true)]
    private ?float $totaltva = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedat = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notepublic = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $noteprive = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $transfert = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    private ?Customers $customerid = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    private ?Myconnectors $origineid = null;


    //Permet de renvoyer par défault a twig le nom du contrat
    public function __toString(): string
    {
        return sprintf(
            'Réf: %s - Client: %s  ',
            $this->referencebr,
            $this->getCustomerid()->getName(),
             $this->getState()
        );
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferencebr(): ?string
    {
        return $this->referencebr;
    }

    public function setReferencebr(?string $referencebr): static
    {
        $this->referencebr = $referencebr;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getRefext(): ?string
    {
        return $this->refext;
    }

    public function setRefext(?string $refext): static
    {
        $this->refext = $refext;

        return $this;
    }

    public function getDolid(): ?int
    {
        return $this->dolid;
    }

    public function setDolid(?int $dolid): static
    {
        $this->dolid = $dolid;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTotalht(): ?float
    {
        return $this->totalht;
    }

    public function setTotalht(?float $totalht): static
    {
        $this->totalht = $totalht;

        return $this;
    }

    public function getTotalttc(): ?float
    {
        return $this->totalttc;
    }

    public function setTotalttc(?float $totalttc): static
    {
        $this->totalttc = $totalttc;

        return $this;
    }

    public function getTotaltva(): ?float
    {
        return $this->totaltva;
    }

    public function setTotaltva(?float $totaltva): static
    {
        $this->totaltva = $totaltva;

        return $this;
    }

    public function getDeletedat(): ?\DateTimeInterface
    {
        return $this->deletedat;
    }

    public function setDeletedat(?\DateTimeInterface $deletedat): static
    {
        $this->deletedat = $deletedat;

        return $this;
    }

    public function getNotepublic(): ?string
    {
        return $this->notepublic;
    }

    public function setNotepublic(?string $notepublic): static
    {
        $this->notepublic = $notepublic;

        return $this;
    }

    public function getNoteprive(): ?string
    {
        return $this->noteprive;
    }

    public function setNoteprive(?string $noteprive): static
    {
        $this->noteprive = $noteprive;

        return $this;
    }

    public function getTransfert(): ?string
    {
        return $this->transfert;
    }

    public function setTransfert(?string $transfert): static
    {
        $this->transfert = $transfert;

        return $this;
    }

    public function getCustomerid(): ?Customers
    {
        return $this->customerid;
    }

    public function setCustomerid(?Customers $customerid): static
    {
        $this->customerid = $customerid;

        return $this;
    }

    public function getOrigineid(): ?Myconnectors
    {
        return $this->origineid;
    }

    public function setOrigineid(?Myconnectors $origineid): static
    {
        $this->origineid = $origineid;

        return $this;
    }


}
