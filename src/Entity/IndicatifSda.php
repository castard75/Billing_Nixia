<?php

namespace App\Entity;

use App\Repository\IndicatifSdaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IndicatifSdaRepository::class)]
class IndicatifSda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    private ?string $label = null;

    #[ORM\Column(length: 10)]
    #[Assert\Type('string')]
    private ?string $codeIso = null;

    #[ORM\Column(length: 50)]
    #[Assert\Type('string')]
    private ?string $zone = null;

    #[ORM\Column(length: 50)]
    #[Assert\Type('string')]
    private ?string $indicatif = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Type('string')]
    private ?string $formatNum = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    private ?string $prefixe = null;

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

    public function getCodeIso(): ?string
    {
        return $this->codeIso;
    }

    public function setCodeIso(string $codeIso): static
    {
        $this->codeIso = $codeIso;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): static
    {
        $this->zone = $zone;

        return $this;
    }

    public function getIndicatif(): ?string
    {
        return $this->indicatif;
    }

    public function setIndicatif(string $indicatif): static
    {
        $this->indicatif = $indicatif;

        return $this;
    }

    public function getFormatNum(): ?string
    {
        return $this->formatNum;
    }

    public function setFormatNum(?string $formatNum): static
    {
        $this->formatNum = $formatNum;

        return $this;
    }

    public function getPrefixe(): ?string
    {
        return $this->prefixe;
    }

    public function setPrefixe(?string $prefixe): static
    {
        $this->prefixe = $prefixe;

        return $this;
    }
}
