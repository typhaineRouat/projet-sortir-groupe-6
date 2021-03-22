<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Sortie;
use App\Form\ListeSortieType;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
	
	/**
     * @Route("/sortie/create", name="sortie_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        //$repositoryLieu = $entityManager->getRepository(Lieu::class);
        //$lieux =  $repositoryLieu->findAll();

        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if($sortieForm->isSubmitted() && $sortieForm->isValid()){

            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success', 'Une Sortie est créée !');
            return $this->redirectToRoute('sortie_create');
        }
        return $this->render('sortie/create.html.twig', [
            'controller_name' => 'SortieController',
            'sortieForm' => $sortieForm->createView(),
        ]);
    }

    /**
     * @Route("/sortie/{id}", name="sortie_details", requirements={"id":"\d+"})
     */
    public function details(int $id, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(sortie::class);
        $sortie = $repository->find($id);
      //  dd($sortie);
        return $this->render('sortie/details.html.twig',[
            'sortie' => $sortie,
        ]);
        
    }
  /**
     * @Route("/", name="sortie_accueil")
     */

    public function accueil(SortieRepository $repository, Request $request)
    {

        $data = new SearchData();
        $dateDuJOur = new \DateTime;
        $accueilForm = $this->createForm(ListeSortieType::class, $data);
        $accueilForm->handleRequest($request);
        $sorties = $repository->findSearch($data);



        return $this->render('sortie/accueil.html.twig', [
            'sorties' => $sorties,
            'dateDuJOur' => $dateDuJOur,
            'accueilForm' => $accueilForm->createView(),

        ]);
    }
}
