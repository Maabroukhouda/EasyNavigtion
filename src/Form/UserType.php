<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class UserType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder    ->add('Email', TextType::class, ['attr' => [
                'placeholder' => "Adresse email",
                'class' => 'form-control',            ]])
            ->add(
                'nomUser',
                TextType::class,
                ['attr' => [
                    'placeholder' => "Nom",
                    'class' => 'form-control',]]
            )
            ->add(
                'Username',
                TextType::class,
                ['attr' => [
                    'placeholder' => "Prénom",
                    'class' => 'form-control',

                ]]
            );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
