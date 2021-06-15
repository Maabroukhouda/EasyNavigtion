<?php

namespace App\Controller\Fournisseur;

use App\Entity\Calandrier;
use App\Entity\Offre;
use App\Entity\Parcs;
use App\Entity\VoyageRegulier;
use App\Entity\User;

use App\Form\EditOffreRegulierType;
use App\Form\EditRegulierType;
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
use App\Form\VoyageRegulierType;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class RegulierController extends AbstractController
{
    #[Route('/Offres/{id}/DetailsRegulier', name : 'DetailsRegulier')]
    public function DetailsRegulier(Offre $offre, $id)
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
            $moyenne_transport = $offre->getMoyenneTransport();
            $regulier = $offre->getVoyageRegulier();
            $contact = $offre->getUser()->getFournisseur()->getnumTel();
            /*$events = $this->getDoctrine()->getRepository(Calendrier::class)->findBy(['voyage_regulier' => $regulier]);
            //dd($events);
            $cal =[];
            foreach ($events as $e){
                $cal[]=[
                    'id'=>$e->getId(),
                    'start'=>$e->getStart()->format('Y-m-d H:i:s'),
                    'end'=>$e->getEnd()->format('Y-m-d H:i:s'),
                    'backgroundColor' => 'red' ,
                    'borderColor' => 'black',
                    'textColor' =>'white'

                ];
            }
            $data = json_encode($cal);*/


            return $this->render('Fournisseur/Regulier/detailsRegulier.html.twig', [
                'offre' => $offre,
                'moyenne_tarnsport' => $moyenne_transport,
                'regulier' => $regulier,
                'contact' => $contact,
               // 'data'=>$data,
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }


    #[Route('/Offres/{id}/ModifierRegulier', name: 'ModifierRegulier')]
    public function ModifierRegulier(ValidatorInterface $validator,Request $request, $id,Offre $offre,EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);

        $voyage_regulier=$offre->getVoyageRegulier();
        $moy_tran = $offre->getMoyenneTransport();
        $uploads_directory = $this->getParameter('uploads_directory');
        $form_edit_regulier = $this->createForm(EditOffreRegulierType::class,$voyage_regulier);
        $form_edit_regulier->handleRequest($request);
        if ($form_edit_regulier->isSubmitted() && $form_edit_regulier->isValid()) {
            $data = $form_edit_regulier->getData();
            $file = $form_edit_regulier->get('moyenneTransport')->get('image')->getData();
            if($file != null){
                $uploads_directory = $this->getParameter('uploads_directory');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $fileName);
                $moy_tran->setImage($fileName);
            }
            $errors = $validator->validate($offre );

            if (count($errors) > 0) {
                return $this->render('Fournisseur/Regulier/editRegulier.html.twig', [
                    'errors' => $errors,
                ]);
            }

            $destination = $form_edit_regulier->get('voyageRegulier')->get('destination')->getData();
            $des = explode(" ", $destination);
            $depart = $form_edit_regulier->get('voyageRegulier')->get('depart')->getData();
            $dep = explode(" ", $depart );


            $voyage_regulier->setDestination(new Point($des[0], $des[1]));
            $voyage_regulier->setDepart(new Point($dep[0], $dep[1]));
            $manager->persist($moy_tran);
            $manager->persist($voyage_regulier);
            $manager->persist($offre);
            $manager->flush();
            return $this->redirectToRoute('DetailsRegulier', ['id' => $id]);
        }
        /*$events = $this->getDoctrine()->getRepository(Calendrier::class)->findBy(['voyage_regulier' => $voyage_regulier]);
        //dd($events);
        $cal =[];
        foreach ($events as $e){
            $cal[]=[
                'id'=>$e->getId(),
                'start'=>$e->getStart()->format('Y-m-d H:i:s'),
                'end'=>$e->getEnd()->format('Y-m-d H:i:s'),
                'backgroundColor' => 'red' ,
                'borderColor' => 'black',
                'textColor' =>'white'

            ];
        }
        $data = json_encode($cal);*/

            return $this->render('Fournisseur/Regulier/editRegulier.html.twig', [
            'formRegulier' => $form_edit_regulier->createView(),
            'moyenneTransport'=>$moy_tran,
                //'data'=>$data,

        ]);
    }


    #[Route('/Offres/{id}/SupprimerRegulier', name: 'SupprimerRegulier')]
    public function SupprimerRegulier(Offre $offre, $id, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $Type_Offre = 'Tous Les Offres';
        $offre1 = $user->getOffres();
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $moy_tran = $offre->getMoyenneTransport();
        $regulier = $offre->getVoyageRegulier();
        $manager->remove($regulier);
        $manager->remove($moy_tran);
        $manager->remove($offre);
        $manager->flush();
        return $this->redirectToRoute('offre');

    }

        #[Route('/Offres/newRegulier', name: 'newVoyageRegulier')]
    public function newVoyageRegulier(ValidatorInterface $validator,Request $request, Security $security,EntityManagerInterface $manager): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $user = $this->getUser();
            $offre = new Offre();
            $moy_tran = new MoyenneTransport();
            $voy_reg = new VoyageRegulier();
            //$user = $security->getUser();
            $form_voy_regulier = $this->createForm(VoyageRegulierType::class);
            $form_voy_regulier->handleRequest($request);
            if ($form_voy_regulier->isSubmitted() && $form_voy_regulier->isValid()) {

                $errors = $validator->validate($offre);
                if (count($errors) > 0) {
                    return $this->render('Fournisseur/Regulier/voyageRegulier.html.twig', [
                        'errors' => $errors,
                    ]);
                }
                $file =  $form_voy_regulier->get('image')->getData();
                if($file != null){

                $uploads_directory = $this->getParameter('uploads_directory');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $uploads_directory,
                    $fileName
                );
                    $moy_tran->setImage($fileName);

                    $data = $form_voy_regulier->getData();


                    $offreType = $this->getDoctrine()
                        ->getRepository(OffreType::class)
                        ->findOneBy(['type' => 'voyage_regulier']);
                    $offre->setOffreType($offreType);
                    $offre->setUser($user);
                    $offre->setPrix($data['prix']);
                    $offre->setNbPlace($data['nbplace']);

                    $voy_reg->setOffre($offre);

                    $destination = $form_voy_regulier->get('destination')->getData();
                    $des = explode(",", $destination);
                    $depart = $form_voy_regulier->get('depart')->getData();
                    $dep = explode(",", $depart );

                    $voy_reg->setDestination(new Point($des[0], $des[1]));
                    $voy_reg->setDepart(new Point($dep[0], $dep[1]));
                    //$voy_reg->setCreatedAt(new \DateTime('now'));
                    $moy_tran->setNom($data['nom']);
                    $moy_tran->setDescription($data['description']);
                    $moy_tran->setOffret($offre);

                    $manager->persist($voy_reg);

                    $dates= $data['date'];
                    $all_date = explode(",", $dates );
                    foreach($all_date as $i){
                        $x =date_create_from_format("j-m-Y",$i);
                        $calandrier = new Calandrier();
                        $calandrier->setDate($x);
                        $calandrier->setVoyageRegulier($voy_reg);
                        $manager->persist($calandrier);
                    }

                    $manager->persist($moy_tran);
                    $manager->flush();

                    return $this->redirectToRoute('offre');
                }
                else {
                    $form_voy_regulier->addError(new FormError('l\'image ne doit pas être nulle.'));
                }
            }

            return $this->render('Fournisseur/Regulier/VoyageRegulier.html.twig', [
                'formVoyageR' => $form_voy_regulier->createView(),
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }
}
