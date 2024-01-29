<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CustomersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomersRepository::class)]
#[ApiResource]
class Customers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $dolid = null;

    #[ORM\Column(nullable: true)]
    private ?int $civility = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $referencesupplier = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $siren = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $additionaladdress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $fixphone = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $mobilephone = null;

    #[ORM\Column(nullable: true)]
    private ?int $cityid = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $postcode = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $namecity = null;

    #[ORM\Column(nullable: true, options: ['default' => 181])]
    private ?int $countryid = 181;

    #[ORM\Column(nullable: true)]
    private ?int $customertypeid = null;

    #[ORM\Column(nullable: true)]
    private ?int $companyid = null;

    #[ORM\Column(nullable: true)]
    private ?int $conditionreglement = null;

    #[ORM\Column(nullable: true)]
    private ?int $modereglement = null;

    #[ORM\Column(nullable: true, options: ['default' => 1])]
    private ?int $status = null;

    #[ORM\Column(nullable: true, options: ['default' => 1])]
    private ?int $state = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $codecompta = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true,options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true,options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $updatedat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedat = null;

    #[ORM\Column(nullable: true)]
    private ?int $customerstate = null;

    #[ORM\Column(nullable: true)]
    private ?int $supplierstate = null;

    #[ORM\Column(nullable: true)]
    private ?int $classe = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datecustomer = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateupdatecustomer = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $transfert = null;

    #[ORM\Column(nullable: true)]
    private ?int $pricelevel = null;

    #[ORM\OneToMany(mappedBy: 'customerid', targetEntity: Contracts::class)]
    private Collection $contracts;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
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

    public function getCivility(): ?int
    {
        return $this->civility;
    }

    public function setCivility(?int $civility): static
    {
        $this->civility = $civility;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

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

    public function getReferencesupplier(): ?string
    {
        return $this->referencesupplier;
    }

    public function setReferencesupplier(?string $referencesupplier): static
    {
        $this->referencesupplier = $referencesupplier;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): static
    {
        $this->siren = $siren;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getAdditionaladdress(): ?string
    {
        return $this->additionaladdress;
    }

    public function setAdditionaladdress(?string $additionaladdress): static
    {
        $this->additionaladdress = $additionaladdress;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFixphone(): ?string
    {
        return $this->fixphone;
    }

    public function setFixphone(?string $fixphone): static
    {
        $this->fixphone = $fixphone;

        return $this;
    }

    public function getMobilephone(): ?string
    {
        return $this->mobilephone;
    }

    public function setMobilephone(?string $mobilephone): static
    {
        $this->mobilephone = $mobilephone;

        return $this;
    }

    public function getCityid(): ?int
    {
        return $this->cityid;
    }

    public function setCityid(?int $cityid): static
    {
        $this->cityid = $cityid;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): static
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getNamecity(): ?string
    {
        return $this->namecity;
    }

    public function setNamecity(?string $namecity): static
    {
        $this->namecity = $namecity;

        return $this;
    }

    public function getCountryid(): ?int
    {
        return $this->countryid;
    }

    public function setCountryid(?int $countryid): static
    {
        $this->countryid = $countryid;

        return $this;
    }

    public function getCustomertypeid(): ?int
    {
        return $this->customertypeid;
    }

    public function setCustomertypeid(?int $customertypeid): static
    {
        $this->customertypeid = $customertypeid;

        return $this;
    }

    public function getCompanyid(): ?int
    {
        return $this->companyid;
    }

    public function setCompanyid(?int $companyid): static
    {
        $this->companyid = $companyid;

        return $this;
    }

    public function getConditionreglement(): ?int
    {
        return $this->conditionreglement;
    }

    public function setConditionreglement(?int $conditionreglement): static
    {
        $this->conditionreglement = $conditionreglement;

        return $this;
    }

    public function getModereglement(): ?int
    {
        return $this->modereglement;
    }

    public function setModereglement(?int $modereglement): static
    {
        $this->modereglement = $modereglement;

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

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCodecompta(): ?string
    {
        return $this->codecompta;
    }

    public function setCodecompta(?string $codecompta): static
    {
        $this->codecompta = $codecompta;

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

    public function getCustomerstate(): ?int
    {
        return $this->customerstate;
    }

    public function setCustomerstate(?int $customerstate): static
    {
        $this->customerstate = $customerstate;

        return $this;
    }

    public function getSupplierstate(): ?int
    {
        return $this->supplierstate;
    }

    public function setSupplierstate(?int $supplierstate): static
    {
        $this->supplierstate = $supplierstate;

        return $this;
    }

    public function getClasse(): ?int
    {
        return $this->classe;
    }

    public function setClasse(?int $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getDatecustomer(): ?\DateTimeInterface
    {
        return $this->datecustomer;
    }

    public function setDatecustomer(?\DateTimeInterface $datecustomer): static
    {
        $this->datecustomer = $datecustomer;

        return $this;
    }

    public function getDateupdatecustomer(): ?\DateTimeInterface
    {
        return $this->dateupdatecustomer;
    }

    public function setDateupdatecustomer(?\DateTimeInterface $dateupdatecustomer): static
    {
        $this->dateupdatecustomer = $dateupdatecustomer;

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

    public function getPricelevel(): ?int
    {
        return $this->pricelevel;
    }

    public function setPricelevel(?int $pricelevel): static
    {
        $this->pricelevel = $pricelevel;

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
            $contract->setCustomerid($this);
        }

        return $this;
    }

    public function removeContract(Contracts $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getCustomerid() === $this) {
                $contract->setCustomerid(null);
            }
        }

        return $this;
    }
}
