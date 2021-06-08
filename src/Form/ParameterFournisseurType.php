<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ParameterFournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('user', UserType::class)
            ->add('cin', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Numero Carte identite',
                    'class' => 'form-control',]
            ])
            ->add('numTel', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Numero de telephone',
                    'class' => 'form-control',]
            ])
            ->add('Enregistrer', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-dark')
            ));
    }

    public function getBlockPrefix()
    {
        return '';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
