<?php

namespace App\Validator;

use App\DTO\TelephoneDTO;
use App\Entity\Controle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainsUniqueAssociateValidator extends ConstraintValidator
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
/*SI la valeur passé en paramètre est pas une instance de TelephoneDTO ou que constraint est pas une instance de ContainsUniqueAssociate on renvoie l'erreur*/
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value instanceof TelephoneDTO) { //Si la valeur n'est pas une instance de TelephoneDTO on renvoie une erreur
            throw new UnexpectedValueException($value, TelephoneDTO::class);
        }

        if (!$constraint instanceof ContainsUniqueAssociate) { //Si la contrainte ne correspond pas à notre contrainte personnalisé on renvoie une érreur
            throw new UnexpectedTypeException($constraint, ContainsUniqueAssociate::class);
        }


//Recupération de l'entité en bdd pour verification
        $controle = $this->em->getRepository(Controle::class)->findOneBy([
            'telephoneid' => $value->getTelephone(),
            'contratid' => $value->getContrat()
        ]);
//Si la ligne est déja présente dans la table Controle on renvoie une erreur
        if ($controle instanceof Controle) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ telephone }}',  $value->getTelephone())
                ->setParameter('{{ contrat }}', $value->getContrat())
                ->addViolation();
        }
   



    }
}