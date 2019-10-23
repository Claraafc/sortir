<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileModificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                "label" => "Votre pseudo",
                "disabled" => true
            ])
            //->add('roles')
            ->add('nom', null, [
                "label" => "Votre nom",
                "disabled" => false
            ])
            ->add('prenom', null, [
                "label" => "Votre prenom",
                "disabled" => false
            ])
            ->add('telephone', null, [
                "label" => "Votre telephone",
                "disabled" => false
            ])
            //->add('email')
            ->add('urlPhoto')
            ->add('site', EntityType::class,  array(

                'class' => Site::class,
                //Attribut utilisé pour l'affichage
                'choice_label' => 'name',

                //Fait une requête particulière
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ))
            ->add('password')
        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
