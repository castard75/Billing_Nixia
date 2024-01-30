<?php

namespace App\Form;

use App\Entity\Contracts;
use App\Entity\Controle;
use App\Entity\Telephone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactLinkingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contratid', EntityType::class,
                    [
                        'class' => Contracts::class,
                        'label' => 'Contrat',
                        'placeholder' => 'Choisir un contrat',
                        'required' => true,
                    ])
            ->add('telephoneid', EntityType::class,
                    [
                        'class' => Telephone::class,
                        'label' => 'Téléphone',
                        'placeholder' => 'Choisir un téléphone',
                        'required' => true,
                    ])
            ->add(
                'create',
                SubmitType::class,
                [
                    'label'  => 'Enregistrer',
                    'attr' => [
                        'class' => 'btn btn-primary btn-block mt-3',
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Controle::class,
        ]);
    }
}