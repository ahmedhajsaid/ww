<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Terrain;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            //->add('dateReservation',DateType::class)
            /*->add('heure')
            ->add('validee')
            ->add('montant')
            ->add('acceptee')


            ->add('client', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom'
            ])
            ->add('terrain', EntityType::class, [
                'class' => Terrain::class,
                'choice_label' => 'designation'
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
