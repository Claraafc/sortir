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
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

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
            ->add('telephone', TextType::class, [
                "label" => "Votre telephone",
                "disabled" => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/'
                    ]),
                ]
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
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false

            ])
            ->add('fileTemp',FileType::class, array(
                'data_class'=> null,
                'label' => 'Ma photo',
                'required' => false))
            ->add('Enregistrer', SubmitType::class)

        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
