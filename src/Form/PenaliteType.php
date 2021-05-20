<?php

namespace App\Form;

use App\Entity\Penalite;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PenaliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('nbrePointsRetires')
            ->add('complexe', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'raisonSociale'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Penalite::class,
        ]);
    }

}
