<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Matche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;

class MatchequipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('dateMatch',DateTimeType::class,[
                'widget' => 'single_text',
            ])

             ->add('equipe1', EntityType::class, [
    // looks for choices from this entity
    'class' => Equipe::class,
                 'label'=>' Equipe :',

    // uses the User.username property as the visible option string
    'choice_label' => 'nom',


    'multiple' => false,
     'expanded' => true,
])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Matche::class,
        ]);
    }
}
