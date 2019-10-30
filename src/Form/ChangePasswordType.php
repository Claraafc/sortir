<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangePasswordType extends AbstractType
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
    protected $oldPassword;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                'mapped' => false,
                'label' => 'Ancien mot de passe'
            ))
            ->add('password', RepeatedType::class, [
                'label' => ' ',
                "type" => PasswordType::class,
                "first_options" => ['label' => "Nouveau mot de passe"],
                "second_options" => ["label" => "Répéter"],
                "mapped" => false,
                'required' => true,
                'invalid_message' => 'Le mot de passe ne correspond pas'
            ])
            ->add('enregistrer', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary btn-enregistrer-modif-mdp'
                )
            ))
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
