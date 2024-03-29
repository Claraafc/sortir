<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('rue')
            ->add('longitude')
            ->add('latitude')
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'name',
                'placeholder' => 'Choissisez une ville',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')->orderBy('v.name', 'ASC');
                },
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez renseigner une ville'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
