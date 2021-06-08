<?php

namespace App\Form;


use App\Entity\LocParcs;
use App\Entity\Parcs;
use App\Form\TypeOffre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EditLocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('moyenneTransport', MoyenneTransportType::class)
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
            )
            ->add('location' , LocParcsType::class)

            ->add('Enregistrer', SubmitType::class, array(

                'attr' => array(

                    'class' => 'btn btn-dark'

                )

            ));
    }
    public function getBlockPrefix()
    {
        return '';
    }
    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Location',
        ]);
    }*/
}
