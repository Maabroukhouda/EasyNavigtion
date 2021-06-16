<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Parcs;
use App\Repository\ParcsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;


class LocParcsType extends AbstractType
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('offre')
            ->add('parcs', EntityType::class, [
                'class' =>Parcs::class,
                'query_builder' => function (ParcsRepository  $er) {
                    return $er->createQueryBuilder('p')
                        ->where( 'p.user = :user' )
                        ->setParameter('user' , $this->security->getUser());
                    // ->findBy(['p.user' => $this->security->getUser() ]);
                },
                // uses the User.username property as the visible option string
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
