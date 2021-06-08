<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Fournisseur;
use App\Entity\SimpleUser;
use App\Form\FournisseurType;
use App\Form\SimpleUserType;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Core\Security;
use function PHPSTORM_META\type;

class SecurityController extends AbstractController
{
    #[Route('/User', name: 'uusers')]
    public function Type(Security $security): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $security->getUser();
        $Type = $user->getUserType()->getType();
        if ($Type == 'Fournisseur') {
            $id = $user->getId();
            return $this->redirectToRoute('offre');
        } else {
            return $this->redirectToRoute('simple_user');
        }
        return $this->render('Fournisseur/Offre.html.twig', []);
    }
    #[Route('/inscription', name: 'security_register')]
    public function Register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, EntityManagerInterface $manager, Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder): Response
    {
        try {
            /*$user = new User();
            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                return $this->render('security/register.html.twig', [
                    'errors' => $errors,
                ]);
            }*/
            $simple_user_form = $this->createForm(SimpleUserType::class);
            $simple_user_form->handleRequest($request);
            $fournisseur_form = $this->createForm(FournisseurType::class);
            $fournisseur_form->handleRequest($request);
            if ($simple_user_form->isSubmitted() && $simple_user_form->isValid()) {
                $data = $simple_user_form->getData();
                $user = new User();
                $user->setEmail($data['Email']);
                $user->setNomUser($data['nomUser']);
                $user->setPassword($data['Password']);
                //$user->CofirmePassword = $data['CofirmePassword'];
                $user->setUsername($data['Username']);
                $type = $this->getDoctrine()
                    ->getRepository(UserType::class)
                    ->find(1);
                $user->setUserType($type);
                $simple_User = new SimpleUser();
                $simple_User->setDataNaissance($data['dataNaissance']);
                $simple_User->setGenre($data['genre']);
                $simple_User->setVille($data['ville']);
                $errors = $validator->validate($user);
                $simple_user_errors = $validator->validate($simple_User);
                if (count($errors) > 0) {
                    return $this->render('security/register.html.twig', [
                        'formInscri' => $simple_user_form->createView(),
                        'formFournisseur' => $fournisseur_form->createView(),
                        'errors' => $errors,
                        'simpleErrors' => $simple_user_errors,
                    ]);
                };
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $manager->persist($user);
                $simple_User->setUser($user);
                $manager->persist($simple_User);
                $manager->flush();
                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,          // the User object you just created
                    $request,
                    $authenticator, // authenticator whose onAuthenticationSuccess you want to use
                    'main'          // the name of your firewall in security.yaml
                );
            }

            if ($fournisseur_form->isSubmitted() && $fournisseur_form->isValid()) {
                $data = $fournisseur_form->getData();
                $user = new User();
                $user->setEmail($data['Email']);
                $user->setNomUser($data['nomUser']);
                $user->setPassword($data['Password']);
                //$user->CofirmePassword = $data['CofirmePassword'];
                $user->setUsername($data['Username']);
                $type = $this->getDoctrine()
                    ->getRepository(UserType::class)
                    ->find(0);
                $user->setUserType($type);
                $fournisseur_user = new Fournisseur();
                $fournisseur_user->setCin($data['cin']);
                $fournisseur_user->setnumTel($data['numTel']);
                $errors = $validator->validate($user);
                $fournisseur_errors = $validator->validate($fournisseur_user);
                if (count($errors) > 0) {
                    return $this->render('security/register.html.twig', [
                        'formInscri' => $simple_user_form->createView(),
                        'formFournisseur' => $fournisseur_form->createView(),
                        'errors' => $errors,
                        'fournisseurErrors' => $fournisseur_errors,
                    ]);
                };
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $manager->persist($user);
                $fournisseur_user->setUser($user);
                $manager->persist($fournisseur_user);
                $manager->flush();
                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,          // the User object you just created
                    $request,
                    $authenticator, // authenticator whose onAuthenticationSuccess you want to use
                    'main'          // the name of your firewall in security.yaml
                );
            }
            return $this->render('security/register.html.twig', [
                'formInscri' => $simple_user_form->createView(),
                'formFournisseur' => $fournisseur_form->createView(),
            ]);
        } catch (FileException $e) {
            error_log($e->getMessage());
        }
    }
    #[Route('/', name: 'security_login')]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }


    #[Route('/deconnexion', name: 'security_logout')]
    public function logout()
    {
    }
}
