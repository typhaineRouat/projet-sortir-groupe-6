<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use App\Form\UtilisateurType;
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
     * @Route("/gestion", name="utilisateur_gestion")
     */
    public function gestionUtilisateur(int $id, Request $request, EntityManagerInterface $em)
    {

        $utilisateurForm = $this->createForm(UtilisateurType::class);

        $utilisateurForm->handleRequest($request);

        $repository = $em->getRepository(Utilisateur::class);
        $utilisateur   = $repository->findOneBy(['id'=>$id]);
        dd($utilisateur);

        if ($utilisateurForm->isSubmitted()){



            $em->persist($utilisateur);
            $em->flush();

            $this->addFlash('success', 'Le profil a bien été modifié');

            return $this->redirectToRoute('register');

        }
        return $this->render('utilisateur/gestion.html.twig',[
            "utilisateurForm" => $utilisateurForm->createView()

        ]);
    }
    
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
