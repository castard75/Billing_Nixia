<?php

namespace App\Entity;
use App\Entity\Invoices;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\InvoicesitemsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvoicesitemsRepository::class)]
#[ApiResource]
class Invoicesitems
{
    public function __construct()
    {
        $this->createdat = new \DateTime('now');

    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')] 
    private ?int $itempriceId = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')] 
    private ?int $specialcode = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')] 
    private ?int $rang = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Type('string')]
    private ?string $des = null;

    #[ORM\Column(nullable: true)]
    private ?float $quantity = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')] 
    private ?int $unite = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')] 
    private ?int $supplierpriceId = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    private ?string $reference = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Type('string')]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('float')] 
    private ?float $ht = null;

    #[ORM\Column]
    #[Assert\Type('float')] 
    private ?float $htachat = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('float')] 
    private ?float $ttc = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('float')] 
    private ?float $tva = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('float')] 
    private ?float $tauxremise = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('float')] 
    private ?float $tauxtva = null;

    #[ORM\Column]
    #[Assert\Type('float')] 
    private ?float $marge = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')] 
    private ?int $modePrice = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')] 
    private ?int $typeRemise = null;

    #[ORM\ManyToOne(inversedBy: 'invoicesitems')]
    #[Assert\Type(Invoices::class)]
    private ?Invoices $invoiceid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\DateTime]
    private ?\DateTimeInterface $createdat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItempriceId(): ?int
    {
        return $this->itempriceId;
    }

    public function setItempriceId(?int $itempriceId): static
    {
        $this->itempriceId = $itempriceId;

        return $this;
    }

    public function getSpecialcode(): ?int
    {
        return $this->specialcode;
    }

    public function setSpecialcode(?int $specialcode): static
    {
        $this->specialcode = $specialcode;

        return $this;
    }

    public function getRang(): ?int
    {
        return $this->rang;
    }

    public function setRang(?int $rang): static
    {
        $this->rang = $rang;

        return $this;
    }

    public function getDes(): ?string
    {
        return $this->des;
    }

    public function setDes(?string $des): static
    {
        $this->des = $des;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnite(): ?int
    {
        return $this->unite;
    }

    public function setUnite(?int $unite): static
    {
        $this->unite = $unite;

        return $this;
    }

    public function getSupplierpriceId(): ?int
    {
        return $this->supplierpriceId;
    }

    public function setSupplierpriceId(?int $supplierpriceId): static
    {
        $this->supplierpriceId = $supplierpriceId;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getHt(): ?float
    {
        return $this->ht;
    }

    public function setHt(?float $ht): static
    {
        $this->ht = $ht;

        return $this;
    }

    public function getHtachat(): ?float
    {
        return $this->htachat;
    }

    public function setHtachat(float $htachat): static
    {
        $this->htachat = $htachat;

        return $this;
    }

    public function getTtc(): ?float
    {
        return $this->ttc;
    }

    public function setTtc(?float $ttc): static
    {
        $this->ttc = $ttc;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getTauxremise(): ?float
    {
        return $this->tauxremise;
    }

    public function setTauxremise(?float $tauxremise): static
    {
        $this->tauxremise = $tauxremise;

        return $this;
    }

    public function getTauxtva(): ?float
    {
        return $this->tauxtva;
    }

    public function setTauxtva(?float $tauxtva): static
    {
        $this->tauxtva = $tauxtva;

        return $this;
    }

    public function getMarge(): ?float
    {
        return $this->marge;
    }

    public function setMarge(float $marge): static
    {
        $this->marge = $marge;

        return $this;
    }

    public function getModePrice(): ?int
    {
        return $this->modePrice;
    }

    public function setModePrice(?int $modePrice): static
    {
        $this->modePrice = $modePrice;

        return $this;
    }

    public function getTypeRemise(): ?int
    {
        return $this->typeRemise;
    }

    public function setTypeRemise(?int $typeRemise): static
    {
        $this->typeRemise = $typeRemise;

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

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): static
    {
        $this->createdat = $createdat;

        return $this;
    }
}
