<?php

namespace App\Form;

use App\Entity\Offre;
use App\Form\EditRegulierType;
use App\Form\moyenneTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditOffreRegulierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depart',HiddenType::class,[
                'attr' => ['id' => 'depart'],])
            ->add('destination',HiddenType::class,[
                'attr' => ['id' => 'destination'],])
        ;
    }
    public function getBlockPrefix()
    {
        return '';
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\VoyageRegulier',
        ]);
    }
   
}
