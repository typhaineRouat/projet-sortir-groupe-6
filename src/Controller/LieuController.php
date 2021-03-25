<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    /**
     * @Route("/lieu/ajoute", name="lieu_ajoute")
     */
    public function ajoute(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $lieu = new Lieu();
        $lieuForm = $this->createForm(LieuType::class,$lieu);
        $lieuForm ->handleRequest($request);
        if($lieuForm->isSubmitted() && $lieuForm->isValid()){

            $entityManager->persist($lieu);
            $entityManager->flush();
            $this->addFlash('success', 'Un Lieu est ajouté !');
            return $this->redirectToRoute('lieu_ajoute');
        }
        return $this->render('lieu/ajoute.html.twig', [
            'controller_name' => 'LieuController',
            'lieuForm' => $lieuForm->createView(),
            'user'=> $user,
        ]);
    }
}
