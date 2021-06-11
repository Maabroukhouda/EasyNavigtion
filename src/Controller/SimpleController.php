<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use App\Form\ParameterSimpleType;
use App\Form\PaswordType;
use App\Form\SearchType;
use App\Entity\Offre;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



class SimpleController extends AbstractController
{
    #[Route('/Offre/{id}/DetailsRegulier', name: 'DetailsRegulierS')]
    public function DetailsRegulier(Offre $offre, $id)
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
            $moyenne_transport = $offre->getMoyenneTransport();
            $regulier = $offre->getVoyageRegulier();
            $contact = $offre->getUser()->getFournisseur()->getnumTel();

            return $this->render('userSimple/detailsRegulier.html.twig', [
                'offre' => $offre,
                'moyenne_tarnsport' => $moyenne_transport,
                'regulier' => $regulier,
                'contact' => $contact,
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }

    #[Route('/Offre/{id}/DetailsLocation', name: 'DetailsLocationS')]
    public function DetailsLocation(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $contact = $offre->getUser()->getFournisseur()->getnumTel();
        $parcs=$offre->getLocation()->getParcs();

        $moyenne_transport = $offre->getMoyenneTransport();
        $user = $offre->getUser();
        return $this->render('userSimple/detailslocation.html.twig', [
            'offre' => $offre,
            'moyenne_tarnsport' => $moyenne_transport,
            'contact' => $contact,
            'parcs'=>$parcs,
        ]);
    }

    #[Route('/Offre/{id}/DetailsOrganiser', name: 'DetailsOrganiserS')]
    public function DetailsOrganiser(Offre $offre, $id)
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
            $moyenne_transport = $offre->getMoyenneTransport();
            $Organier = $offre->getVoyageOrganiser();
            $date = $Organier->getDatee();
            $contact = $offre->getUser()->getFournisseur()->getnumTel();

            return $this->render('userSimple/detailsOrganiser.html.twig', [
                'offre' => $offre,
                'moyenne_tarnsport' => $moyenne_transport,
                'organier' => $Organier,
                'contact' => $contact
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }

    #[Route('/Offre', name: 'simple_user')]
    public function userSimple(Request $request, OffreRepository $offre_repository, EntityManagerInterface $manager)
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $formSearch = $this->createForm(SearchType::class);
            $formSearch->handleRequest($request);
            $min_prix = $formSearch->get('minPrix')->getData();
            $min_nb_place = $formSearch->get('minNbplace')->getData();
            $max_prix = $formSearch->get('maxPrix')->getData();
            $depart = $formSearch->get('depart')->getData();
            //dd($depart);
            $destiantion = $formSearch->get('destination')->getData();

            //$date = $formSearch->get('date')->getData();
            $offres = $offre_repository->FilterDate($min_prix, $max_prix, $min_nb_place,$depart, $destiantion);

            return $this->render('userSimple/simpleUser.html.twig', [
                'offres' => $offres,
                'formSerach' => $formSearch->createView(),
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }
    #[Route('/Offre/parametre', name: 'parametreS')]
    public function Parameter(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $user = $this->getUser();
            $simple_user = $user->getSimpleUser();
            $formsimple = $this->createForm(ParameterSimpleType::class, $simple_user);
            $formsimple->handleRequest($request);
            if ($formsimple->isSubmitted() && $formsimple->isValid()) {
                $manager->persist($simple_user);
                $manager->persist($user);
                $manager->flush();
                return $this->redirectToRoute('simple_user');
            }


            $formPass = $this->createForm(PaswordType::class, $user);
            $formPass->handleRequest($request);
            if ($formPass->isSubmitted() &&  $formPass->isValid()) {
                $new_password = $formPass->get('Password')->getData();
                $new_password = $passwordEncoder->encodePassword($user, $new_password);
                $user->setPassword($new_password );
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');
                return $this->redirectToRoute('simple_user');
            }
            else {
                    $formPass->addError(new FormError('Ancien mot de passe incorrect'));
            }

            return $this->render('userSimple/parameter.html.twig', [
                'formEdit' => $formsimple->createView(),
                'formpass' => $formPass->createView(),
                'user' => $user,
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }


    #[Route('/Offre/parametre/supprimer', name: 'SupprimerS')]
    public function SupprimerSimple( EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $simple = $user->getSimpleUser();
        $manager->remove($simple);
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('security_login');

        //return $this->render('Fournisseur/parameter.html.twig', []);
    }
}
