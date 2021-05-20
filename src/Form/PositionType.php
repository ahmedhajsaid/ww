<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('POSITION', ChoiceType::class, [
            'choices'  => [
                'ATT' => 'ATT',
                'MID1' => 'MID1',
                'MID2' => 'MID2',
                'DD2' => 'DD2',
                'DD1' => 'DD1',
                'GG' => 'GG',

            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
