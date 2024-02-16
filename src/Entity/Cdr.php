<?php

namespace App\Entity;

use App\Repository\CdrRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CdrRepository::class)]
class Cdr
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Type('integer')]
    private ?int $sipTrunk = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    private ?string $caller = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    private ?string $called = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateAt = null;

    #[ORM\Column]
    #[Assert\Type('float')]
    private ?float $price = null;

    #[ORM\Column]
    #[Assert\Type('integer')]
    private ?int $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    private ?string $devise = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    private ?string $origin = null;

    #[ORM\Column]
    #[Assert\Type('integer')]
    private ?int $originId = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    private ?string $anomaly = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    private ?string $comment = null;

    #[ORM\Column]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    private ?string $iso = null;

    #[ORM\Column(length: 1)]
    #[Assert\Type('string')]
    private ?string $status = null;

    #[ORM\Column(length: 1)]
    #[Assert\Type('string')]
    private ?string $activate = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    private ?string $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSipTrunk(): ?int
    {
        return $this->sipTrunk;
    }

    public function setSipTrunk(int $sipTrunk): static
    {
        $this->sipTrunk = $sipTrunk;

        return $this;
    }

    public function getCaller(): ?string
    {
        return $this->caller;
    }

    public function setCaller(string $caller): static
    {
        $this->caller = $caller;

        return $this;
    }

    public function getCalled(): ?string
    {
        return $this->called;
    }

    public function setCalled(string $called): static
    {
        $this->called = $called;

        return $this;
    }

    public function getDateAt(): ?\DateTimeImmutable
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeImmutable $dateAt): static
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): static
    {
        $this->devise = $devise;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getOriginId(): ?int
    {
        return $this->originId;
    }

    public function setOriginId(int $originId): static
    {
        $this->originId = $originId;

        return $this;
    }

    public function getAnomaly(): ?string
    {
        return $this->anomaly;
    }

    public function setAnomaly(?string $anomaly): static
    {
        $this->anomaly = $anomaly;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getIso(): ?string
    {
        return $this->iso;
    }

    public function setIso(?string $iso): static
    {
        $this->iso = $iso;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getActivate(): ?string
    {
        return $this->activate;
    }

    public function setActivate(string $activate): static
    {
        $this->activate = $activate;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
}
