<?php

namespace App\Form;

use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de la sortie", 'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un nom'
                    ]),
                ]

            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => "Date et heure de la sortie",
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') + 10),
            ])
            ->add('dateCloture', DateType::class, [
                'label' => "Date limite d'inscription",
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') + 10),
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'label' => "Nombre de places",
                'attr' => ['min' => 1]
            ])
            ->add('duree', ChoiceType::class, [
                'label' => "Durée",
                'choices' => [
                    '1h' => '60',
                    '1h30' => '90',
                    '2h' => '120',
                    '2h30' => '150',
                    '3h' => '180',
                    '3h30' => '210',
                    '4h' => '240',
                    '5h' => '300',
                    '>5h' => '3000',
                ]
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'name',
                'mapped' => false,
                'placeholder' => 'Choissisez une ville',
                /*'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une ville'
                    ])
                ]*/


            ])
            ->add('lieu', null, [
                'choice_label' => 'nom',
                'placeholder' => 'Choissisez un lieu',
              /*  'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un lieu'
                    ])
                ]*/
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('urlPhoto', FileType::class, [
                'label' => "Photo de l'évènement",
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'accept' => 'image/*'
                ],
            ])
            ->add('rue', TextType::class, [
                'disabled' => true,
                'mapped' => false,
            ])
            ->add('latitude', TextType::class, [
                'disabled' => true,
                'mapped' => false,
            ])
            ->add('longitude', TextType::class, [
                'disabled' => true,
                'mapped' => false,
            ])
            ->add('codePostal', TextType::class, [
                'disabled' => true,
                'mapped' => false,
            ]);
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
