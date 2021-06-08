<?php

namespace App\Controller\Fournisseur;

use App\Entity\Offre;
use App\Entity\VoyageOrganiser;
use App\Form\EditOrganiserType;
use CrEOF\Spatial\PHP\Types\AbstractPoint;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Security;
use App\Entity\OffreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\MoyenneTransport;
use App\Form\VoyageOrganiserType;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class OrganiserController extends AbstractController
{
    #[Route('/Offres/{id}/DetailsOrganiser', name: 'DetailsOrganiser')]
    public function DetailsOrganiser(Offre $offre, $id)
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
            $moyenne_transport = $offre->getMoyenneTransport();
            $Organier = $offre->getVoyageOrganiser();
            $date = $Organier->getDatee();
            $contact = $offre->getUser()->getFournisseur()->getnumTel();

            return $this->render('Fournisseur/Organiser/detailsOrganiser.html.twig', [
                'offre' => $offre,
                'moyenne_tarnsport' => $moyenne_transport,
                'organier' => $Organier,
                'contact' => $contact
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }


    #[Route('/Offres/{id}/ModifierOrganiser', name: 'ModifierOrganiser')]
    public function ModifierOrganiser(ValidatorInterface $validator,Request $request, $id,Offre $offre,EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $voyage_organiser =$offre->getVoyageOrganiser();
        $moy_tran = $offre->getMoyenneTransport();
        $uploads_directory = $this->getParameter('uploads_directory');
        $form_edit_organiser = $this->createForm(EditOrganiserType::class,$offre);
        $form_edit_organiser->handleRequest($request);
        if($form_edit_organiser->isSubmitted() && $form_edit_organiser->isValid()){
            $data = $form_edit_organiser->getData();
            $file = $form_edit_organiser->get('moyenneTransport')->get('image')->getData();
            if($file != null){
                $uploads_directory = $this->getParameter('uploads_directory');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $fileName);
                $moy_tran->setImage($fileName);
            }
            $destination = $form_edit_organiser->get('voyageOrganiser')->get('destination')->getData();
            $des = explode(" ", $destination);
            $depart = $form_edit_organiser->get('voyageOrganiser')->get('depart')->getData();
            $dep = explode(" ", $depart );

            $voyage_organiser->setDestination(new Point($des[0], $des[1]));
            $voyage_organiser->setDepart(new Point($dep[0], $dep[1]));
            $errors = $validator->validate($offre );

            if (count($errors) > 0) {
                return $this->render('Fournisseur/Organiser/editOrganiser.html.twig', [
                    'errors' => $errors,
                ]);
            }
            $manager->persist($moy_tran);
            $manager->persist($voyage_organiser);
            $manager->persist($offre);
            $manager->flush();
            return $this->redirectToRoute('DetailsOrganiser', ['id' => $id]);
        }
        return $this->render('Fournisseur/Organiser/editOrganiser.html.twig', [
            'formOrganiser' => $form_edit_organiser->createView(),
            'moyenneTransport'=>$moy_tran
        ]);
    }

    #[Route('/Offres/{id}/SupprimerOrganiser', name: 'SupprimerOrganiser')]
    public function SupprimerOrganiser(Offre $offre, $id, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $Type_Offre = 'Tous Les Offres';
        $offre1 = $user->getOffres();
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $moy_tran = $offre->getMoyenneTransport();
        $organiser = $offre->getVoyageOrganiser();
        $manager->remove($organiser);
        $manager->remove($moy_tran);
        $manager->remove($offre);
        $manager->flush();
        return $this->redirectToRoute('offre', );

    }

    #[Route('/Offres/newOrganiser', name: 'newVoyageOrganiser')]
    public function newVoyageOrganiser(ValidatorInterface $validator,Request $request,  Security $security): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $user = $this->getUser();
            $form_voy_organiser = $this->createForm(VoyageOrganiserType::class);
            $form_voy_organiser->handleRequest($request);
            if ($form_voy_organiser->isSubmitted() && $form_voy_organiser->isValid()) {
                $file =  $form_voy_organiser->get('image')->getData();
                if($file != null) {
                    $uploads_directory = $this->getParameter('uploads_directory');
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                    $file->move(
                        $uploads_directory,
                        $fileName
                    );
                    $data = $form_voy_organiser->getData();

                    $offreType = $this->getDoctrine()
                        ->getRepository(OffreType::class)
                        ->findOneBy(['type' => 'voyage_organiser']);
                    $offre = new Offre();
                    $offre->setOffreType($offreType);
                    $offre->setPrix($data['prix']);
                    $offre->setUser($user);
                    $offre->setNbplace($data['nbplace']);
                    $voy_org = new VoyageOrganiser();
                    $voy_org->setOffre($offre);
                    $voy_org->setDatee($data['datee']);

                    $destination = $form_voy_organiser->get('destination')->getData();
                    $des = explode(",", $destination);

                    $depart = $request->request->get('depart');
                    $dep = explode(",", $depart);

                    $voy_org->setDestination(new Point($des[0], $des[1]));
                    $voy_org->setDepart(new Point($dep[0], $dep[1]));
                    //$voy_org->setCreatedAt(new \DateTime('now'));
                    $moy_tran = new MoyenneTransport();
                    $moy_tran->setNom($data['nom']);
                    $moy_tran->setImage($fileName);
                    $moy_tran->setDescription($data['description']);
                    $moy_tran->setOffret($offre);
                    $errors = $validator->validate($offre);

                    if (count($errors) > 0) {
                        return $this->render('Fournisseur/Regulier/editRegulier.html.twig', [
                            'errors' => $errors,
                        ]);
                    }
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($moy_tran);
                    $entityManager->persist($voy_org);
                    $entityManager->flush();
                    return $this->redirectToRoute('offre');
                }
                else {
                    $form_voy_organiser->addError(new FormError('l\'image ne doit pas être nulle.'));
                }
            }
            return $this->render('Fournisseur/Organiser/voyageOrganiser.html.twig', [
                'formVoyageO' => $form_voy_organiser->createView(),
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }
}
