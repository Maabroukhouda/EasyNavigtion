<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;



class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('user', UserType::class)

            ->add('Email', TextType::class, ['attr' => [
                'placeholder' => "Adresse email",
                'class' => 'form-control',

            ]])
            ->add(
                'nomUser',
                TextType::class,
                ['attr' => [
                    'placeholder' => "Nom",
                    'class' => 'form-control',

                ]]
            )
            ->add(
                'Username',
                TextType::class,
                ['attr' => [
                    'placeholder' => "Prénom",
                    'class' => 'form-control',

                ]]
            )->add('Password', RepeatedType::class, array(

                'type' => PasswordType::class,


                'first_options' => array(
                    'label' => '   ',

                    'attr' => array(

                        'placeholder' => "Mot de passe",
                        'class' => 'form-control',
                    )

                ), 'second_options' => array(
                    'label' => '    ',

                    'attr' => array(

                        'placeholder' => "Confirmer Mot de passe",
                        'class' => 'form-control',
                    )

                ),
                'required' => true,

            ))
            ->add('cin', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Numero Carte identite',
                    'class' => 'form-control',
                ]
            ])

            ->add('numTel', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Numero de telephone',
                    'class' => 'form-control',
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
            'data_class' => Fournisseur::class,
        ]);
    }*/
}
