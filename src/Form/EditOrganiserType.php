<?php

namespace App\Form;

use App\Entity\Offre;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditOrganiserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'prix',
                NumberType::class,
                ['attr' => [
                    'placeholder' => "Prix",
                    'class' => 'form-control',]])
            ->add(
                'nb_place',
                NumberType::class,
                ['attr' => [
                    'placeholder' => "nombre de place",
                    'class' => 'form-control',]])
            ->add('voyageOrganiser' , EditOffreOrganiserType::class)
            ->add('moyenneTransport' , MoyenneTransportType::class)
            ->add('Enregistrer', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-dark')
            ));
    }
    public function getBlockPrefix()
    {
        return '';
    }
    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }*/
}
