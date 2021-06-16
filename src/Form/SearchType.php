<?php

namespace App\Form;

use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depart', HiddenType::class,[
                'attr' => ['id' => 'depart'],
            ])
            ->add('destination',HiddenType::class,[
                'attr' => ['id' => 'destination'],
            ])

            ->add('maxPrix', IntegerType::class, [
                'required' => false,
                'label' => false,
                'empty_data' => 'INF',
                'attr' => [
                    'placeholder' => 'Prix maximale',
                    'class' => 'form-control',
                ]
            ])
            ->add('disatnce' , IntegerType::class,
                [
                    'required' => false,
                    'label' => false,
                    'empty_data' => 0,
                    'attr' => [
                        'placeholder' => 'La distance ne dépasse pas en kilometre',
                        'class' => 'form-control',
                    ]
                ])
            ->add('minPrix', IntegerType::class, [
                'required' => false,
                'label' => false,
                'empty_data' => 0,
                'attr' => [
                    'placeholder' => 'Prix minimale',
                    'class' => 'form-control',
                ]
            ])
            /*->add('date', DateType::class, [
                'required' => false,
                'label' => false,
                'data' => new DateTime(),
                'attr' => [
                    'placeholder' => 'Prix maximale',
                    'class' => 'form-control',

                ]
            ])*/
            ->add('minNbplace', IntegerType::class, [
                'required' => false,
                'label' => false,
                'empty_data' => 1,
                'attr' => [
                    'placeholder' => 'Nombre de place minimale',
                    'class' => 'form-control',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
