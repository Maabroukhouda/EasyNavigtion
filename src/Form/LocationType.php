<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Offre;
use App\Entity\Parcs;
use App\Repository\ParcsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;





class LocationType extends AbstractType
{
    private $security;
    private $p_r;

    public function __construct(Security $security , ParcsRepository  $er)
    {
        $this->security = $security;
        $this->p_r = $er;

    }

    public function buildForm(FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add(
                'prix',
                NumberType::class,
                [
                    'label' => false,
                    'attr' => [
                    'placeholder' => "Prix",
                    'class' => 'form-control',

                ]]
            )->add(
                'nb_place',
                NumberType::class,
                [    'label' => false,
                    'attr' => [
                    'placeholder' => "Nombre de place",
                    'class' => 'form-control',

                ]]
            )
            ->add('nom',  ChoiceType::class, [

                'choices'  => [
                    'Bicyclette' => 'Bicyclette',
                    'Camion' => 'Camion',
                    'Voiture'=>'Voiture',
                    'Scooter'=>'Scooter',
                    'Autocaravane'=>'Autocaravane',
                    'Bus'=>'Bus',
                    'Taxi'=>'Taxi',

                ],
                'attr' => [
                    'label' => false,
                    'class' => 'form-select',
                    'expanded' => false,
                    'multiple' => false
                ]
            ])
            ->add(
                'image',
                FileType::class,
                [
                    'label' => false,
                    'mapped' => false,
                    'required' => false,
                    'attr' => [

                        'class' => 'form-control',

                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class,[
                'label' => false,
                'attr' => [
                        'placeholder' => "Description",
                        'class' => 'form-control',

                    ]
            ])
            ->add('parcs', EntityType::class, [
            'class' =>Parcs::class,
            'query_builder'=>$this->parc_User(),
            'choice_label'  => function ($U_parcs,$nb) {
                    //$nb=$parcs->count($parcs);
                    for ($i =0 ; $i<= $nb ; $i++) {
                        $x='parc '.($i+1);
                    }
                    return  $x;
                          },
           'attr' => [

               'label' => false,
               'class' => 'form-select',
               'expanded' => false,
               'multiple' => false
           ]
        ]);

    }
    public function parc_User () {
        return $this->p_r->createQueryBuilder('p')
            ->where( 'p.user = :user' )
            ->setParameter('user' , $this->security->getUser());
    }
    public function getBlockPrefix()
    {

        return '';
    }
    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }*/
}
