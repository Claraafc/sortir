<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use function Sodium\add;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de la sortie"
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => "Date et heure de la sortie",
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+10),
            ])
            ->add('dateCloture', DateType::class, [
                'label' => "Date limite d'inscription",
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+10),
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'label' => "Nombre de places",
            ])
            ->add('duree', ChoiceType::class, [
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
        ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'name',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')->orderBy('v.name', 'ASC');
                },
                'mapped' => false
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('l')->orderBy('l.nom', 'ASC');
                }
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
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
