<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('email', EmailType::class)
            ->add('site', EntityType::class,  array(

                'class' => Site::class,
                //Attribut utilisé pour l'affichage
                'choice_label' => 'name',
                'label' => 'Ville de rattachement',
                //Fait une requête particulière
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ))
            ->add('password', RepeatedType::class, [
                'label' => ' ',
                "type" => PasswordType::class,
                "first_options" => ['label' => "Mot de passe"],
                "second_options" => ["label" => "Répéter"],

            ])
            ->add('urlPhoto',FileType::class, array(
                'data_class'=> null,
                'label' => 'Ma photo',
                'required' => false))
            ->add('Enregistrer', SubmitType::class)
            ->add('Annuler', SubmitType::class, array(
                'label' => 'Annuler',
                'attr' => array('class' => 'btn btn-danger')))

        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
