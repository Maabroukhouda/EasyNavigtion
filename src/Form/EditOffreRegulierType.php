<?php

namespace App\Form;

use App\Form\CalandrierType;
use App\Form\moyenneTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditOffreRegulierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depart',HiddenType::class,[
                'attr' => ['id' => 'depart'],])
            ->add('destination',HiddenType::class,[
                'attr' => ['id' => 'destination'],])
            ->add('offre' , EditRegulierType::class)
            ->add('date',
                TextType::class,
                ['attr' => [
                    'id'=>'date',
                    'placeholder' => "les dates du voyage ",
                    'class' => 'form-control date',
                ]
                ]
            )            ->add('Enregistrer', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-dark')
            ))
        ;
    }
    public function getBlockPrefix()
    {
        return '';
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\VoyageRegulier',
        ]);
    }
   
}
