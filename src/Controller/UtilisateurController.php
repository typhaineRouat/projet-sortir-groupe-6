<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UtilisateurController extends AbstractController
{
    

    /**
     * @route("/login", name="user_login")
     */
    public function login(AuthenticationUtils $utils): Response
    {


    return $this->render("utilisateur/login.html.twig", [
        'loginError'      => $utils->getLastAuthenticationError(),
        'loginUsername'   => $utils->getLastUsername(),

        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function  logout()
    {

    }

    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(
        Request                      $request,
        EntityManagerInterface       $entityManager,
        UserPasswordEncoderInterface $encoder,
    ): Response {
        $utilisateur            = new Utilisateur;
        $registrationForm = $this->createForm(RegistrationType::class, $utilisateur);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $utilisateur->setPassword($encoder->encodePassword($utilisateur, $utilisateur->getPassword()));
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            $this->addFlash('success', 'Inscription réussie');
            return $this->redirectToRoute('user_login');
        }

        return $this->render('utilisateur/register.html.twig', [
            'controller_name'  => 'UtilisateurController',
            'registrationForm' => $registrationForm->createView(),
        ]);
    }

  
    }
}
