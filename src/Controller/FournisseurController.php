<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\OffreType;
use App\Entity\User;

use App\Form\ParameterFournisseurType;
use App\Form\PaswordType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Security;



class FournisseurController extends AbstractController
{
    #[Route('/Offres/', name: 'offre')]
    public function Offre(Request $request): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $offre = $request->query->get('offre');
            $user = $this->getUser();
            //$Type = $user->getUserType()->getType();

            // if ($Type == 'Fournisseur') {
            if ($offre == null) {
                $offre1 = $user->getOffres();
                $Type_Offre = 'Tous Les Offres';
            } else {
                $offreType = $this->getDoctrine()
                    ->getRepository(OffreType::class)
                    ->findOneBy(['type' => $offre]);

                if ($offreType->getType() == 'voyage_organiser') {
                    $Type_Offre = 'Offres: Voyage Organiser';

                } elseif ($offreType->getType() == 'voyage_regulier') {
                    $Type_Offre = 'Offres: Voyage Regulier';
                } elseif ($offreType->getType() == 'location') {
                    $Type_Offre = 'Offres: Location Des Moyenne de transport ';
                }
                $offre1 = $this->getDoctrine()
                    ->getRepository(Offre::class)
                    ->findBy(['offreType' => $offreType, 'user' => $user]);
            }
            return $this->render('fournisseur/offre.html.twig', [
                'offres' => $offre1,
                'offreType' => $Type_Offre,

            ]);
            /* } else {
                return $this->redirectToRoute('simple_user');
            }*/
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }

    #[Route('/Offres/parametre/supprimer', name: 'Supprimer')]
    public function SupprimerFournisseur( EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $fournisseur = $user->getFournisseur();
        $manager->remove($fournisseur);
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('security_login');


        //return $this->render('Fournisseur/parameter.html.twig', []);
    }


    #[Route('/Offres/parametre', name: 'parametre')]
    public function Parameter(Request $request,  Security $security, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $fournisseur = $user->getFournisseur();
        $formFou = $this->createForm(ParameterFournisseurType::class,$fournisseur);
        $formFou->handleRequest($request);
        if ($formFou->isSubmitted() && $formFou->isValid()){
            $manager->persist($fournisseur);
            $manager->persist($user);
                $manager->flush();
                return $this->redirectToRoute('offre');
        }

        $user_password =$user->getPassword();
        $formPass = $this->createForm(PaswordType::class);
        $formPass->handleRequest($request);
        if ($formPass->isSubmitted() &&  $formPass->isValid()) {
            $oldPassword = $formPass->get('oldPassword')->getData();

            // $oldPassword = $request->request->get('user')['oldPassword'];

            // Si l'ancien mot de passe est bon

            $user_password =$user->getPassword();
            //$user_password = $passwordEncoder->encodePassword($user, $user->getPassword());
            if($passwordEncoder->isPasswordValid($user, $oldPassword)){
                $new_password = $formPass->get('Password')->getData();
                $new_password = $passwordEncoder->encodePassword($user, $new_password);

                $user->setPassword($new_password );

                $manager->persist($user);

                $manager->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('offre');
            }
             else {

                $formPass->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }



        return $this->render('Fournisseur/parameter.html.twig', [
            'formEdit' => $formFou->createView(),
            'formpass' => $formPass->createView(),
            'user' => $user,
            'fournisseur'=>$fournisseur,
        ]);
    }
}
