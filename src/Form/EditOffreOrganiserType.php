<?php

namespace App\Form;

use App\Entity\VoyageOrganiser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EditOffreOrganiserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depart',HiddenType::class,[
                'attr' => ['id' => 'depart'],
            ])
            ->add('destination',HiddenType::class,[
                'attr' => ['id' => 'destination'],])
            ->add('datee', DateType::class)
        ;
    }
    public function getBlockPrefix()
    {
        return '';
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\VoyageOrganiser',
        ]);
    }
}
