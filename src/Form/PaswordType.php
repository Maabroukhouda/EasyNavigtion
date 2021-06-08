<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class PaswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('oldPassword', PasswordType::class, ['attr' => [
                'label' => false,
                'mapped' => false,
                'placeholder' => "mot de passe actuel",
                'class' => 'form-control',

            ]])

            ->add('Password', RepeatedType::class, array(

                'type' => PasswordType::class,

                'invalid_message' => 'Les deux mots de passe doivent être identiques',

                'first_options' => array(
                    'label' => '   ',

                    'attr' => array(

                        'placeholder' => "Nouveau mot de passe ",
                        'class' => 'form-control',
                    )

                ), 'second_options' => array(
                    'label' => '    ',

                    'attr' => array(

                        'placeholder' => 'Confirmer le mot de passe',
                        'class' => 'form-control',
                    )

                ),
                'required' => true,

            ))

            ->add('Enregistrer', SubmitType::class, array(

                'attr' => array(

                    'class' => 'btn btn-dark'

                )

            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
