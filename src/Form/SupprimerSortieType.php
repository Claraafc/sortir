<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class SupprimerSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'disabled' => true,
            ])
            ->add('motif', TextareaType::class, [
                'label' => "Motif de l'annulation",
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer un motif d'annulation de la sortie"
                    ]),
                    new Length(['min' => 10, 'minMessage' => "{{ limit }} caractères minimum !"]),
                    new Regex(['pattern' => '/([0-9_-]*[a-zA-Z][0-9_-]*){3}/', 'message' => "3 lettres minimum"])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
