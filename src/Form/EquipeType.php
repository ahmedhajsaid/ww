<?php

namespace App\Form;

use App\Entity\Equipe;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label'=>'NOM :',
                'attr'=>[
                    'placeholder'=>'Nom Equipe',
                    'class'=>'nom'
                ]
            ])
            ->add('nbreJoueur',IntegerType::class,[
                'label'=>'Nombre Equipe :',
                'attr'=>[
                    'placeholder'=>'Nombre Equipe',
                    'class'=>'nbreJoueur'
                ]
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
