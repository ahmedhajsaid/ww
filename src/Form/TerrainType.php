<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Terrain;
use App\Entity\Utilisateur;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('description')
            ->add('ville',ChoiceType::class, [
                'choices' => array(
                    "Ariana" => "Ariana",
                    "Béja"=> "Béja",
                    "Ben Arous"=> "Ben Arous",
                    "Bizerte" => "Bizerte",
                    "Gabes" => "Gabes",
                    "Gafsa" => "Gafsa",
                    "Jendouba" => "Jendouba",
                    "Kairouan" => "Kairouan",
                    "Kasserine" => "Kasserine",
                    "Kebili" =>"Kebili" ,
                    "Kef" => "Kef",
                    "Mahdia" => "Mahdia",
                    "Manouba" => "Manouba",
                    "Medenine" => "Medenine",
                    "Manastir" => "Manastir",
                    "Nabeul"  => "Nabeul",
                    "Sfax" => "Sfax",
                    "Sidi Bouzid" =>"Sidi Bouzid" ,
                    "Siliana" => "Siliana",
                    "Sousse" => "Sousse",
                    "Tataouine" => "Tataouine",
                    "Tozeur" => "Tozeur",
                    "Tunis" => "Tunis",
                    "Zaghouan" => "Zaghouan"
                )
            ])
            ->add('adresse')
            ->add('image' , FileType::class, array('data_class' => null))
            ->add('disponible')
            ->add('prixLocation', IntegerType::class)
            ->add('heureOuverture', null, [
                'label' => "Heure d'ouverture"])
            ->add('heureFermeture', null, [
                'label' => 'Heure de fermeture'
            ] )

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
            'data_class' => Terrain::class,
        ]);
    }


}
