<?php
//  Lors de l'enregistrement d'un utilisateur, envoyé un mot de passe hashé depuis le react n'est pas sécurisé donc j'ai mis en place un UserDTO qui récupère les données envoyé depuis react et pour créé un nouvel utilisateur,
//  dans cette classe je crée des propriétés qui recoivent la data qui sera initialié dans UserCreateProcessor 
namespace App\ApiResource\DTO;

class UserDTO
{
    
    private ?string $email = null;
    private ?string $password = null;
    private ?string $name = null;



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
