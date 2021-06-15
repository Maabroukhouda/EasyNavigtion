<?php

namespace App\Form;

use App\Entity\VoyageRegulier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class VoyageRegulierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depart',HiddenType::class,[
                'attr' => ['id' => 'depart'],
            ])
            ->add('destination',HiddenType::class,[
                'attr' => ['id' => 'destination'],
            ])
            ->add(
                'nbplace',
                NumberType::class,
                ['attr' => [
                    'placeholder' => "Nombre de place",
                    'class' => 'form-control',

                ]]
            )
            ->add(
                'prix',
                NumberType::class,
                ['attr' => [
                    'placeholder' => "Prix en dinar par jour",
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
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control',

                    ]
                ]
            )
            ->add('date',
                TextType::class,
                ['attr' => [
                    'placeholder' => "les dates du voyage ",
                    'class' => 'form-control date',

                ]
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                ['attr' => [
                    'placeholder' => "Description",
                    'class' => 'form-control',

                ]]
            );
    }
    public function getBlockPrefix()
    {
        return '';
    }
    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VoyageRegulier::class,
        ]);
    }*/
}
