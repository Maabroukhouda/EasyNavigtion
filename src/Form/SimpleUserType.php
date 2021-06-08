<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;





class SimpleUserType extends AbstractType
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
            )
            ->add(
                'Password',
                PasswordType::class,
                ['attr' => [
                    'placeholder' => "Mot de passe",
                    'class' => 'form-control',

                ]]
            )

            ->add(
                'CofirmePassword',
                PasswordType::class,
                ['attr' => [
                    'placeholder' => "Confirmer Mot de passe",
                    'class' => 'form-control',

                ]]
            )
            ->add('dataNaissance', BirthdayType::class, ['attr' => [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
            ]])

            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Male' => 'Male',
                    'Femmel' => 'Femmel',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('ville',  ChoiceType::class, [

                'choices'  => [
                    'Ariana' => 'Ariana',
                    'Béja' => 'Béja',
                    'Ben Arous' => 'Ben Arous',
                    'Bizerte' => 'Bizerte',
                    'Gabès' => 'Gabès',
                    'Gafsa' => 'Gafsa',
                    'Jendouba' => 'Jendouba',
                    'Kairouan' => 'Kairouan',
                    'Kasserine' => 'Kasserine',
                    'Kébili' => 'Kébili',
                    'Le Kef' => 'Le Kef',
                    'Mahdia' => 'Mahdia',
                    'La Manouba' => 'La Manouba',
                    'Médenine' => 'Médenine',
                    'Monastir' => 'Monastir',
                    'Nabeul' => 'Nabeul',
                    'Sfax' => 'Sfax',
                    'Sidi Bouzid' => 'Sidi Bouzid',
                    'Siliana' => 'Siliana',
                    'Sousse' => 'Sousse',
                    'Tataouine' => 'Tataouine',
                    'Tozeur' => 'Tozeur',
                    'Tunis' => 'Tunis',
                    'Zaghouan' => 'Zaghouan',
                ],
                'attr' => [
                    'label' => false,
                    'class' => 'form-select',
                    'expanded' => false,
                    'multiple' => false
                ]
            ]);
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => SimpleUser::class,
    //     ]);
    // }
    public function getBlockPrefix()
    {
        return '';
    }
}
