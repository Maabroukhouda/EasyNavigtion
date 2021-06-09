<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Parcs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocParcsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('offre')
            ->add('parcs', EntityType::class, [
                'class' =>Parcs::class,

                // uses the User.username property as the visible option string
                'choice_label'  => function ($parcs,$nb) {
                    for ($i =0 ; $i<= $nb ; $i++) {
                        $x='point '.($i+1);

                    }
                    return  $x;
                },
                'attr' => [
                    'label' => false,
                    'class' => 'form-select',
                    'expanded' => false,
                    'multiple' => false
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
