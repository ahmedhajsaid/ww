<?php

namespace App\Form;

use App\Entity\Matche;
use App\Entity\Penalite;
use App\Entity\PenaliteJoueur;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PenaliteJoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('heure')
            ->add('arbitre',EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'raisonSociale'
            ])
            ->add('joueur',EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'raisonSociale'
            ])
            ->add('matche',EntityType::class, [
                'class' => Matche::class,
                'choice_label' => 'id'
            ])
            ->add('penalite',EntityType::class, [
                'class' => Penalite::class,
                'choice_label' => 'designation'
            ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PenaliteJoueur::class,
        ]);
    }
}
