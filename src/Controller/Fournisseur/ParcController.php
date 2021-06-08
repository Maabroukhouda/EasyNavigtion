<?php

namespace App\Controller\Fournisseur;

use App\Entity\OffreType;
use App\Entity\Parcs;
use App\Form\ParcsType;
use CrEOF\Spatial\PHP\Types\AbstractPoint;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class ParcController extends AbstractController
{

    #[Route('/Offres/Parc', name: 'parc')]
    public function parc(Request $request): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $user = $this->getUser();
            //$user = $security->getUser();
            $form_parc = $this->createForm(ParcsType::class);
            $form_parc->handleRequest($request);
            if ($form_parc->isSubmitted() && $form_parc->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();

                //$data = $form_parc->getData();

                $location= $form_parc->get('location')->getData();

                $locat = explode(" ", $location);
                $nb =count($locat)+1;
                foreach($locat as $i){
                    $parc = new Parcs();
                   $loca = explode(",", $i);
                   $parc->setLocation(new Point($loca[0], $loca[1]));
                   $parc->setUser($user);
                   $entityManager->persist($parc);

               }
                $entityManager->flush();
                return $this->redirectToRoute('parc');
            }
            $all_parcs="";
            $user_parc =$this->getDoctrine()
                ->getRepository(Parcs::class)
                ->findAll(['user' => $user->getId()]);
            foreach($user_parc as $parc){
                $point=strval($parc->getlocation());
               $all_parcs .=$point.",";
            }
            //$all_parcs=json_encode($user_parc);
            return $this->render('fournisseur/parc/Parc.html.twig', [
              'form' => $form_parc->createView(),
              'userparc'=>$user_parc,
              'all_parc'=>$all_parcs,
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }

    #[Route('/Offres/Parc/{id}/delete', name: 'delete_parc')]
    public function delete_parc(Request $request,$id,EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $parc = $this->getDoctrine()->getRepository(Parcs::class)->find($id);
        $manager->remove($parc);
        $manager->flush();
            return $this->redirectToRoute('parc');
    }

}
