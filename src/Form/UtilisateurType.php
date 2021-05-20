<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\Categorie;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email')

            ->add('password')

            ->add('nom')
            ->add('prenom')
            ->add('raisonSociale')

            ->add('position')
            ->add('telephone')
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
