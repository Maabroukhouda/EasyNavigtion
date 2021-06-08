<?php

namespace App\Form;
use App\Entity\MoyenneTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoyenneTransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

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
                        'label' => false,
                        'class' => 'form-control',

                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                ['attr' => [
                    'label' => false,
                    'placeholder' => "Description",
                    'class' => 'form-control',

                ]]
            );
    }
    public function getBlockPrefix()
    {
        return '';
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => MoyenneTransport::class,
        ));
    }
}
