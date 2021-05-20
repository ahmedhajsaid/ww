<?php

namespace App\Form;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\Competition;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\ResolvedFormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type;
class CompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>' la desgniation'
            ,'attr'=>[
                'placeholder'=>'entrer le desgniation',
                    'class'=>'desgniation'
                ]

            ])

              ->add('dateCreation', DateType::class, [

                   'widget' => 'single_text',
                   // this is actually the default format for single_text
                   'format' => 'yyyy-MM-dd',
               ])


            ->add('dateDebut',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>' la date'
                ,'attr'=>[
                    'placeholder'=>'entrer le date',
                    'class'=>'dateDebut'
                ]

            ])



            ->add('nbreEquipes',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>' la nbreEquipes'
                ,'attr'=>[
                    'placeholder'=>'entrer le nbreEquipes',
                    'class'=>'nbreEquipes'
                ]

            ])
            ->add('prixParticipation',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>' la prixParticipation'
                ,'attr'=>[
                    'placeholder'=>'entrer le prixParticipation',
                    'class'=>'prixParticipation'
                ]

            ])
            ->add('complexe', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'raisonSociale'
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
            'data_class' => Competition::class,
        ]);
    }
}
