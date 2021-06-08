<?php

namespace App\Form;

use App\Form\MoyenneTransportType;
use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;



class TypeOffre extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'prix',
                NumberType::class,
                ['attr' => [
                    'placeholder' => "Prix",
                    'class' => 'form-control',

                ]]
            )
            ->add(
                'nb_place',
                NumberType::class,
                ['attr' => [
                    'placeholder' => "nombre de place",
                    'class' => 'form-control',

                ]]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>Offre::class,
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
