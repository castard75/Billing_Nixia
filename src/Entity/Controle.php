<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ControleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Customers;
use App\Entity\Contracts;
use App\Entity\Myconnectors;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ControleRepository::class)]
#[ApiResource]
class Controle
{

    public function __construct()
    {
        $this->createdat = new \DateTime('now');
        $this->updatedat = new \DateTime('now');
        $this->startserviceat = new \DateTime('now');
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')]
    private ?int $dolid = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\Type('string')]
    private ?string $name = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\Type('string')]
    private ?string $trprincipal = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\Type('string')]
    private ?string $trsecondaire = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\Type('string')]
    private ?string $codesite = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Assert\Type('string')]
    private ?string $adresseip = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Type('string')]
    private ?string $reference = null;

    #[ORM\Column(nullable: true ,options: ['default' => 1] )]
    #[Assert\Type('integer')]
    private ?int $status = 1;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true ,options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Assert\DateTime]
    private ?\DateTimeInterface $createdat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true ,options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Assert\DateTime]
    private ?\DateTimeInterface $updatedat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeInterface $deletedat = null;

    #[ORM\Column(length: 1, nullable: true)]
    #[Assert\Type('string')]
    private ?string $transfert = null;

    #[ORM\ManyToOne]
    #[Assert\Type(Customers::class)]
    private ?Customers $customerid = null;

    #[ORM\Column(nullable: true ,options: ['default' => 1])]
    #[Assert\Type('integer')]
    private ?int $niveau = 1;

    #[ORM\ManyToOne]
    #[Assert\Type(Contracts::class)]
    private ?Contracts $contratid = null;

    #[ORM\ManyToOne]
    #[Assert\Type(Telephone::class)]
    private ?Telephone $telephoneid = null;

    #[ORM\ManyToOne]
    #[Assert\Type(Myconnectors::class)]
    private ?Myconnectors $origineid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeInterface $startserviceat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeInterface $outserviceat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeInterface $endserviceat = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTrprincipal(): ?string
    {
        return $this->trprincipal;
    }

    public function setTrprincipal(?string $trprincipal): static
    {
        $this->trprincipal = $trprincipal;

        return $this;
    }

    public function getTrsecondaire(): ?string
    {
        return $this->trsecondaire;
    }

    public function setTrsecondaire(?string $trsecondaire): static
    {
        $this->trsecondaire = $trsecondaire;

        return $this;
    }

    public function getCodesite(): ?string
    {
        return $this->codesite;
    }

    public function setCodesite(?string $codesite): static
    {
        $this->codesite = $codesite;

        return $this;
    }

    public function getAdresseip(): ?string
    {
        return $this->adresseip;
    }

    public function setAdresseip(?string $adresseip): static
    {
        $this->adresseip = $adresseip;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(?\DateTimeInterface $createdat): static
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(?\DateTimeInterface $updatedat): static
    {
        $this->updatedat = $updatedat;

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

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(?int $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getContratid(): ?Contracts
    {
        return $this->contratid;
    }

    public function setContratid(?Contracts $contratid): static
    {
        $this->contratid = $contratid;

        return $this;
    }

    public function getTelephoneid(): ?Telephone
    {
        return $this->telephoneid;
    }

    public function setTelephoneid(?Telephone $telephoneid): static
    {
        $this->telephoneid = $telephoneid;

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

    public function getStartserviceat(): ?\DateTimeInterface
    {
        return $this->startserviceat;
    }

    public function setStartserviceat(?\DateTimeInterface $startserviceat): static
    {
        $this->startserviceat = $startserviceat;

        return $this;
    }

    public function getOutserviceat(): ?\DateTimeInterface
    {
        return $this->outserviceat;
    }

    public function setOutserviceat(?\DateTimeInterface $outserviceat): static
    {
        $this->outserviceat = $outserviceat;

        return $this;
    }

    public function getEndserviceat(): ?\DateTimeInterface
    {
        return $this->endserviceat;
    }

    public function setEndserviceat(?\DateTimeInterface $endserviceat): static
    {
        $this->endserviceat = $endserviceat;

        return $this;
    }
}
