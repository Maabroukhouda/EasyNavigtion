<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Offre;
use App\Entity\Parcs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;





class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'prix',
                NumberType::class,
                [
                    'label' => false,
                    'attr' => [
                    'placeholder' => "Prix",
                    'class' => 'form-control',

                ]]
            )->add(
                'nb_place',
                NumberType::class,
                [    'label' => false,
                    'attr' => [
                    'placeholder' => "Nombre de place",
                    'class' => 'form-control',

                ]]
            )
            ->add('nom',  ChoiceType::class, [

                'choices'  => [
                    'Bicyclette' => 'Bicyclette',
                    'Camion' => 'Camion',
                    'Voiture'=>'Voiture',
                    'Scooter'=>'Scooter',
                    'Autocaravane'=>'Autocaravane',
                    'Bus'=>'Bus',
                    'Taxi'=>'Taxi',

                ],
                'attr' => [
                    'label' => false,
                    'class' => 'form-select',
                    'expanded' => false,
                    'multiple' => false
                ]
            ])
            ->add(
                'image',
                FileType::class,
                [
                    'label' => false,
                    'mapped' => false,
                    'required' => false,
                    'attr' => [

                        'class' => 'form-control',

                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class,[
                'label' => false,
                'attr' => [
                        'placeholder' => "Description",
                        'class' => 'form-control',

                    ]
            ])
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
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }*/
}
