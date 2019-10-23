<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use function Sodium\add;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entre un nom pour la sortie"
                    ])
                ],
                'label' => "Nom de la sortie"
            ])
            ->add('dateDebut', DateTimeType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer une date de sortie"
                    ]),
                ],
                'label' => "Date et heure de la sortie",
            ])
            ->add('dateCloture', DateType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer une date limite pour clôturer les inscriptions"
                    ]),
                ],
                'label' => "Date limite d'inscription",
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez préciser un nombre maximum de participants pour la sortie",
                    ]),
                ],
                'label' => "Nombre de places",
                            ])
            ->add('duree', ChoiceType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez préciser combien de temps va durer la sortie",
                    ])
                ],
                'label' => "Durée",
                'choices' => [
                    '60 minutes' => '60',
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
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
           /* ->add('site', EntityType::class, [
                'class' => Sortie::class,
                'choice_label' => 'siteVille',
                'mapped' => false,
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
               // 'choice_label' => 'nomVille',
                'mapped' => false,
            ])*/
            ->add('lieu', EntityType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer un nom de lieu"
                    ])

                ],
               'label' => 'Lieu :',
                'class' => Lieu::class,
                //'choice_label' => "nomLieu",
            ])
           /* ->add('rue', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer une rue"
                    ])
                ],
               // 'class' => Lieu::class,
                'mapped' => false,
            ])
            ->add('codePostal', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentre un code postal"
                    ])
                ],
                'mapped' => false,
            ])
            ->add('latitude', TextType::class, [
                'mapped' => false,
            ])
            ->add('longitude', TextType::class, [
                'mapped' => false,
            ])*/
            ->add('Enregistrer', SubmitType::class, [
                'attr' => [
                    'name' => "_enregistrer",
                    'id' => "enregistrer",
                ]
           ])
            ->add('Publier', SubmitType::class, [
                'attr' => [
                    'name' => "_publier",
                    'id' => "publier",
                ]
            ])
            ->add('Annuler', SubmitType::class, [
                'attr' => [
                    'name' => "_annuler",
                    'id' => "annuler",
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
