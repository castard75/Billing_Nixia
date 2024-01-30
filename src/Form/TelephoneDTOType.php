<?php

namespace App\Form;

use App\DTO\TelephoneDTO;
use App\Entity\Contracts;
use App\Entity\Telephone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TelephoneDTOType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', EntityType::class, [
                'class' => Telephone::class,
                'choice_label' => 'name',
                'attr' => ['hidden' => true]
            ])
            ->add('telephoneAffiche', TextType::class, [
                'data' => $options['data']->getTelephone() ? $options['data']->getTelephone()->getName() : '',
                'mapped' => false,
                'label' => 'Numéro de téléphone',
                'disabled' => true
            ])
            ->add('contrat', EntityType::class, [            //On retourne le contrat avec valeurs name et referencebr (fonction magique)
                'class' => Contracts::class,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TelephoneDTO::class, //class à laquelle les données du formulaire sont liées.
            'csrf_protection' => true,
        ]);
    }
}