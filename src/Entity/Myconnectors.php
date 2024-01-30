<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MyconnectorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MyconnectorsRepository::class)]
#[ApiResource]
class Myconnectors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $login = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?int $connectorid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true ,options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true ,options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $updatedat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true )]
    private ?\DateTimeInterface $deletedat = null;

    #[ORM\OneToMany(mappedBy: 'origineid', targetEntity: Contracts::class)]
    private Collection $contracts;

    #[ORM\OneToMany(mappedBy: 'origineid', targetEntity: Customers::class)]
    private Collection $customers;

    #[ORM\OneToMany(mappedBy: 'origineid', targetEntity: Invoices::class)]
    private Collection $invoices;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->customers = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getConnectorid(): ?int
    {
        return $this->connectorid;
    }

    public function setConnectorid(?int $connectorid): static
    {
        $this->connectorid = $connectorid;

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

    /**
     * @return Collection<int, Contracts>
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contracts $contract): static
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts->add($contract);
            $contract->setOrigineid($this);
        }

        return $this;
    }

    public function removeContract(Contracts $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getOrigineid() === $this) {
                $contract->setOrigineid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Customers>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customers $customer): static
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->setOrigineid($this);
        }

        return $this;
    }

    public function removeCustomer(Customers $customer): static
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getOrigineid() === $this) {
                $customer->setOrigineid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invoices>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoices $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setOrigineid($this);
        }

        return $this;
    }

    public function removeInvoice(Invoices $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getOrigineid() === $this) {
                $invoice->setOrigineid(null);
            }
        }

        return $this;
    }
}
