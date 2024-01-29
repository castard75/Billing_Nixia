<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MyconnectorsRepository;
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
}
