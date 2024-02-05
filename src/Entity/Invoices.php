<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\InvoicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoicesRepository::class)]
#[ApiResource]
class Invoices
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $referencebr = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $refext = null;

    #[ORM\Column(nullable: true)]
    private ?int $state = null;

    #[ORM\Column(nullable: true)]
    private ?int $dolid = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datelimit = null;

    #[ORM\Column(nullable: true)]
    private ?int $conditions = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalht = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalttc = null;

    #[ORM\Column(nullable: true)]
    private ?float $totaltva = null;

    #[ORM\Column(nullable: true)]
    private ?float $topay = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedat = null;

    #[ORM\Column(nullable: true,options: ['default' => 1])]
    private ?int $mode = 1;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notepublic = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    private ?Myconnectors $origineid = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $noteprive = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $transfert = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    private ?Customers $customerid = null;

    #[ORM\OneToMany(mappedBy: 'invoiceid', targetEntity: Invoicesitems::class)]
    private Collection $invoicesitems;

    #[ORM\OneToMany(mappedBy: 'invoiceid', targetEntity: LinkContractInvoice::class)]
    private Collection $linkContractInvoices;


    public function __construct()
    {
        $this->invoicesitems = new ArrayCollection();
        $this->linkContractInvoices = new ArrayCollection();
        $this->createdat = new \DateTime('');
        $this->updatedat = new \DateTime('');
        $this->date = new \DateTime('');
        $this->type = "0";
        $this->transfert = 0;
        $this->state = 0;
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

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): static
    {
        $this->state = $state;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDatelimit(): ?\DateTimeInterface
    {
        return $this->datelimit;
    }

    public function setDatelimit(?\DateTimeInterface $datelimit): static
    {
        $this->datelimit = $datelimit;

        return $this;
    }

    public function getConditions(): ?int
    {
        return $this->conditions;
    }

    public function setConditions(?int $conditions): static
    {
        $this->conditions = $conditions;

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

    public function getTopay(): ?float
    {
        return $this->topay;
    }

    public function setTopay(?float $topay): static
    {
        $this->topay = $topay;

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

    public function getMode(): ?int
    {
        return $this->mode;
    }

    public function setMode(?int $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

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

    public function getOrigineid(): ?Myconnectors
    {
        return $this->origineid;
    }

    public function setOrigineid(?Myconnectors $origineid): static
    {
        $this->origineid = $origineid;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, Invoicesitems>
     */
    public function getInvoicesitems(): Collection
    {
        return $this->invoicesitems;
    }

    public function addInvoicesitem(Invoicesitems $invoicesitem): static
    {
        if (!$this->invoicesitems->contains($invoicesitem)) {
            $this->invoicesitems->add($invoicesitem);
            $invoicesitem->setInvoiceid($this);
        }

        return $this;
    }

    public function removeInvoicesitem(Invoicesitems $invoicesitem): static
    {
        if ($this->invoicesitems->removeElement($invoicesitem)) {
            // set the owning side to null (unless already changed)
            if ($invoicesitem->getInvoiceid() === $this) {
                $invoicesitem->setInvoiceid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LinkContractInvoice>
     */
    public function getLinkContractInvoices(): Collection
    {
        return $this->linkContractInvoices;
    }

    public function addLinkContractInvoice(LinkContractInvoice $linkContractInvoice): static
    {
        if (!$this->linkContractInvoices->contains($linkContractInvoice)) {
            $this->linkContractInvoices->add($linkContractInvoice);
            $linkContractInvoice->setInvoiceid($this);
        }

        return $this;
    }

    public function removeLinkContractInvoice(LinkContractInvoice $linkContractInvoice): static
    {
        if ($this->linkContractInvoices->removeElement($linkContractInvoice)) {
            // set the owning side to null (unless already changed)
            if ($linkContractInvoice->getInvoiceid() === $this) {
                $linkContractInvoice->setInvoiceid(null);
            }
        }

        return $this;
    }

    
}
