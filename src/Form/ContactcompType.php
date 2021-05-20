<?php

namespace App\Form;
use App\Entity\ContactAdmin;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\ResolvedFormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type;
class ContactcompType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>' First name'
            ,'attr'=>[
                'placeholder'=>'entrer votre nom',
                    'class'=>'firstname'
                ]

            ])






            ->add('Lastname',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>' last name'
                ,'attr'=>[
                    'placeholder'=>'entrer prenom',
                    'class'=>'lastname'
                ]

            ])
            ->add('phone',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>' N telephone'
                ,'attr'=>[
                    'placeholder'=>'entrer le numero mobile',
                    'class'=>'phone'
                ]

            ])
            ->add('email',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>' Email'
                ,'attr'=>[
                    'placeholder'=>'entrer l email',
                    'class'=>'email'
                ]

            ])
            ->add('equipe',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>' Votre equipe'
                ,'attr'=>[
                    'placeholder'=>'entrer l equipe',
                    'class'=>'equipe'
                ]

            ])
            ->add('message',\Symfony\Component\Form\Extension\Core\Type\TextareaType::class,['label'=>' Message'
                ,'attr'=>[
                    'placeholder'=>'entrer votre  Message',
                    'class'=>'message'
                ]

            ])
            ->add('envoyer', Type\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactAdmin::class,
        ]);
    }
}
