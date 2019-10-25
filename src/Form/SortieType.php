<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                'years' => range(date('Y'), date('Y') + 10),
            ])
            ->add('dateCloture', DateType::class, [
                'label' => "Date limite d'inscription",
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') + 10),
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
                //'attr' => ['name' => 'ville', 'id' => "ville"],
                /*'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')->orderBy('v.name', 'ASC');
                },*/
                'mapped' => false
            ])
            /* $formModifier = function (FormInterface $form, Ville $ville = null) {
                 $lieux = null === $ville ? [] : $ville->getLieux();

                 $form->add('lieu', EntityType::class, [
                     'class' => Lieu::class,
                     'choices' => $lieux,
                 ]);
             };

             $builder->addEventListener(
                 FormEvents::PRE_SET_DATA,
                 function (FormEvent $event) use ($formModifier) {

                     $data = $event->getData();
                     $formModifier($event->getForm(), $data->getName());
                 }
             );
             $builder->get('ville')->addEventListener(
                 FormEvents::POST_SUBMIT,
                 function (FormEvent $event) use ($formModifier) {
                     $ville = $event->getForm()->getData();
                     $formModifier($event->getForm()->getParent(), $ville);
                 }
             )*/
            ->add('lieu', null, [
                //'class' => Lieu::class,
                'choice_label' => 'nom',
                // 'attr' => ['name' => 'lieu', 'id' => "lieu"],
                /*'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('l')->orderBy('l.nom', 'ASC');
                }*/
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
            ->add('rue', TextType::class,[
                "disabled" => true,
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
