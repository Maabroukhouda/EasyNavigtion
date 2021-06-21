<?php

namespace App\Form;

use App\Entity\Calandrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalandrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('date',
                    TextType::class,
                ['attr' => [
                    'id'=>'date',
                    'placeholder' => "les dates du voyage ",
                    'class' => 'form-control date',
                ]
                ]
            )

       ;
    }

   /* public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  'App\Entity\Calandrier',
        ]);
    }*/
}
