<?php

namespace App\DTO;

use App\Entity\Contracts;
use App\Entity\Telephone;
use App\Validator as AcmeAssert;
use Symfony\Component\Validator\Constraints as Assert;


#[AcmeAssert\ContainsUniqueAssociate]
class TelephoneDTO
{
    /**
     * @var Telephone|null
     */
    #[Assert\Type(Telephone::class)]
    private $telephone;

    /**
     * @var Contracts|null
     */
    #[Assert\Type(Contracts::class)]
    public $contrat;

    /**
     * @return Telephone|null
     */
    public function getTelephone(): ?Telephone
    {
        return $this->telephone;
    }

    /**
     * @param Telephone $telephone
     * @return TelephoneDTO
     */
    public function setTelephone(Telephone $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }


    public function getContrat(): ?Contracts
    {
        return $this->contrat;
    }

    /**
     * @param Contracts $contrat
     * @return TelephoneDTO
     */
    public function setContrat(Contracts $contrat): self
    {
        $this->contrat = $contrat;
        return $this;
    }



}