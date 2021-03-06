<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditRegulierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add(
            'prix',
            NumberType::class,
            ['attr' => [
                'placeholder' => "Prix",
                'class' => 'form-control',]])
            ->add(
                'nb_place',
                NumberType::class,
                ['attr' => [
                    'placeholder' => "nombre de place",
                    'class' => 'form-control',]])


            ->add('moyenneTransport' , MoyenneTransportType::class)
            ;

    }
    public function getBlockPrefix()
    {
        return '';
    }
    public function configureOptions(OptionsResolver $resolver)
       {
           $resolver->setDefaults([
               'data_class' => 'App\Entity\Offre',
           ]);
       }
}
