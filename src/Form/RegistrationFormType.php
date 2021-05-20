<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('nom',TextareaType::class,[
                'label'=>'Nom :',
                'attr'=>[
                    'placeholder'=>'Nom',
                    'class'=>'nom'
                ]
            ])
            ->add('prenom',TextareaType::class,[
                'label'=>'Prénom :',
                'attr'=>[
                    'placeholder'=>'Prenom',
                    'class'=>'prenom'
                ]
            ])
            ->add('telephone',TextareaType::class,[
                'label'=>'Téléphone :',
                'attr'=>[
                    'placeholder'=>'Telephone',
                    'class'=>'telephone'
                ]
            ])
            ->add('position',TextareaType::class,[
                'label'=>'Position :',
                'attr'=>[
                    'placeholder'=>'Position',
                    'class'=>'telephone'
                ]
            ])


            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'designation'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
