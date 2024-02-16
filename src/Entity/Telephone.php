<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TelephoneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TelephoneRepository::class)]
#[ApiResource]
class Telephone
{

    public function __construct()
    {
        $this->createdat = new \DateTime('now');
        $this->updatedat = new \DateTime('now');
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Type('integer')] 
    #[ORM\Column(nullable: true)]
    private ?int $dolid = null;

    #[Assert\Type('string')]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $name = null;

    #[Assert\Length(
        
        max: 150,
        maxMessage: 'La longueur ne doit pas dépasser 150 characteres',
    )]
    #[Assert\Type('string')]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $trprincipal = null;

    #[Assert\Length(
        
        max: 150,
        maxMessage: 'La longueur ne doit pas dépasser 150 characteres',
    )]
    #[Assert\Type('string')]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $trsecondaire = null;

    #[Assert\Length(
        
        max: 150,
        maxMessage: 'La longueur ne doit pas dépasser 150 characteres',
    )]
    #[Assert\Type('string')]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $codesite = null;

    #[Assert\Length(
        
        max: 150,
        maxMessage: 'La longueur ne doit pas dépasser 150 characteres',
    )]
    #[Assert\Type('string')]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $adresseip = null;

    #[Assert\Length(
        
        max: 50,
        maxMessage: 'La longueur ne doit pas dépasser 50 characteres',
    )]
    #[Assert\Type('string')]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $reference = null;

    #[Assert\PositiveOrZero]
    #[Assert\Type('integer')] 
    #[ORM\Column(nullable: true,options: ['default' => 1] )]
    private ?int $status = 1;

    #[Assert\DateTime]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true ,options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdat = null;

    #[Assert\DateTime]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true,options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $updatedat = null;

    #[Assert\DateTime]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedat = null;

    #[Assert\Length(
        
        min: 1,
        mminMessage: 'La longueur ne doit pas minimum 1 characteres',
    )]
    #[Assert\Type('string')]
    #[ORM\Column(length: 1, nullable: true)]
    private ?string $transfert = null;

    
    #[ORM\ManyToOne]
    private ?Customers $customerid = null;

    #[Assert\Type('integer')] 
    #[ORM\Column(nullable: true, options: ['default' => 1] )]
    private ?int $niveau = 1;

    #[ORM\ManyToOne]
    private ?Contracts $contratid = null;

    #[ORM\ManyToOne]
    private ?Myconnectors $origineid = null;

    #[Assert\DateTime]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startserviceat = null;

    #[Assert\DateTime]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $outserviceat = null;

    #[Assert\DateTime]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endserviceat = null;
    
    public function __toString(): string
    {
        return sprintf(
            '%s',
            $this->name,
        );
    }

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
