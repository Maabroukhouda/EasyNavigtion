<?php

namespace App\Controller\Fournisseur;

use App\Entity\Offre;
use App\Entity\Parcs;
use App\Entity\User;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Security;
use App\Entity\OffreType;
use App\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\MoyenneTransport;
use App\Form\EditLocationType;
use App\Form\MoyenneTransportType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LocationsController extends AbstractController
{


    #[Route('/Offres/{id}/DetailsLocation', name: 'DetailsLocation')]
    public function DetailsLocation(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $contact = $offre->getUser()->getFournisseur()->getnumTel();
        $parcs=$offre->getLocation()->getParcs();
        $moyenne_transport = $offre->getMoyenneTransport();
        $user = $offre->getUser();
        return $this->render('Fournisseur/Location/detailslocation.html.twig', [
            'offre' => $offre,
            'moyenne_tarnsport' => $moyenne_transport,
            'contact' => $contact,
            'parcs'=>$parcs,
            ]);
    }



    #[Route('/Offres/{id}/ModifierLocation', name: 'ModifierLocation')]
    public function ModifierLocation(ValidatorInterface $validator,Request $request, $id, Offre $offre, EntityManagerInterface $manager)
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
            $moy_tran = $offre->getMoyenneTransport();
            $uploads_directory = $this->getParameter('uploads_directory');
            $form_edit_Location = $this->createForm(EditLocationType::class, $offre);
            $form_edit_Location->handleRequest($request);
            if ($form_edit_Location->isSubmitted() && $form_edit_Location->isValid()) {
                $data = $form_edit_Location->getData();
                 $file = $form_edit_Location->get('moyenneTransport')->get('image')->getData();
                if($file != null){
                    $uploads_directory = $this->getParameter('uploads_directory');
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move(
                        $uploads_directory,
                        $fileName);
                    $moy_tran->setImage($fileName);
                }
                $errors = $validator->validate($offre);

                if (count($errors) > 0) {
                    return $this->render('Fournisseur/Location/location.html.twig', [
                        'errors' => $errors,
                    ]);
                }
                $manager->persist($moy_tran);
                $manager->persist($offre);
                $manager->flush();
                return $this->redirectToRoute('DetailsLocation', ['id' => $id]);
            }
            return $this->render('Fournisseur/Location/editlocation.html.twig', [
                'formLocation' => $form_edit_Location->createView(),
                // 'formTransport' => $form_edit_transport->createView(),
                'offre' => $offre,
                'moyenneTransport'=>$moy_tran,
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }



    #[Route('/Offres/SupprimerLocation/{id}', name: 'SupprimerLocation')]
    public function SupprimerLocation(Offre $offre, $id, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $Type_Offre = 'Tous Les Offres';
        $offre1 = $user->getOffres();
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $location = $offre->getLocation();
        $moy_tran = $offre->getMoyenneTransport();
        $manager->remove($location);
        $manager->remove($moy_tran);

        $manager->remove($offre);
        $manager->flush();
        return $this->redirectToRoute('offre' );

    }

    #[Route('/Offres/newLocation', name: 'newLocation')]
    public function newLocation(ValidatorInterface $validator,Request $request,  Security $security): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $user = $this->getUser();
            $U_parcs =$this->getDoctrine()->getRepository(Parcs::class)->findBy(['user' => $user]);
            //$parcs= $this->getDoctrine()->getRepository(Parcs::class)->find($user);
            //dd($U_parcs);

            //$user_parc = $user->getparcs();
            //$nb = $user_parc->count();
            //dd($nb);
            //$user = $security->getUser();
            $form_location = $this->createForm(LocationType::class);
            $form_location->handleRequest($request);
            if ($form_location->isSubmitted() && $form_location->isValid()) {
                $file = $form_location->get('image')->getData();
                if($file != null){
                    $uploads_directory = $this->getParameter('uploads_directory');
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                    $file->move(
                        $uploads_directory,
                        $fileName
                    );

                    $data = $form_location->getData();
                    $offreT = $this->getDoctrine()
                        ->getRepository(OffreType::class)
                        ->findOneBy(['type' => 'location']);
                    $offre = new Offre();
                    $offre->setOffreType($offreT);

                    $offre->setPrix($data['prix']);

                    $offre->setNbPlace($data['nb_place']);
                    $offre->setUser($user);
                    //$offre->setCreatedAt(new \DateTime('now'));
                    $location = new Location();
                    $location->setOffre($offre);
                    $location->setParcs($data['parcs']);
                    $moy_tran = new MoyenneTransport();
                    $moy_tran->setNom($data['nom']);
                    $moy_tran->setImage($fileName);
                    $moy_tran->setDescription($data['description']);
                    $moy_tran->setOffret($offre);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($moy_tran);
                    $entityManager->persist($location);
                    $entityManager->flush();
                    return $this->redirectToRoute('offre');
                }
                else {
                    $form_location->addError(new FormError('l\'image ne doit pas être nulle.'));
                }
            }
            return $this->render('Fournisseur/Location/location.html.twig', [
                'formLocation' => $form_location->createView(),
                'parcs'=>$U_parcs,
                //'nb'=>$nb,
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }
}
