<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\ListeSortieType;
use App\Form\SortieType;
use App\Repository\EtatRepository;
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
    public function create(Request $request, EntityManagerInterface $entityManager, EtatRepository $etatRepository): Response
    {
        $user = $this->getUser();
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $user = $this->getUser();
            $sortie->setOrganisateur($user);
            $etat = $etatRepository->find(1);

            $sortie->setEtat($etat);

            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success', 'Une Sortie est créée !');
            return $this->redirectToRoute('sortie_create');
        }
        return $this->render('sortie/create.html.twig', [
            'controller_name' => 'SortieController',
            'sortieForm' => $sortieForm->createView(),
            'user'=> $user,
        ]);
    }

    /**
     * @Route("/sortie/{id}", name="sortie_details", requirements={"id":"\d+"})
     */
    public function details(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $repository = $entityManager->getRepository(sortie::class);
        $sortie = $repository->find($id);
        return $this->render('sortie/details.html.twig', [
            'sortie' => $sortie,
            'user'=> $user,
        ]);

    }

    /**
     * @Route("/", name="sortie_accueil")
     */

    public function accueil(SortieRepository $repository, Request $request)
    {
        $user = $this->getUser();
        $data = new SearchData();
        $dateDuJOur = new \DateTime;
        $dateArchive =new \DateTime ;
        $dateArchive ->sub(new \DateInterval('P1M'));
        $accueilForm = $this->createForm(ListeSortieType::class, $data);
        $accueilForm->handleRequest($request);
        $sorties = $repository->findSearch($data, $user);


        return $this->render('sortie/accueil.html.twig', [
            'user'=> $user,
            'dateArchive'=>$dateArchive,
            'sorties' => $sorties,
            'dateDuJOur' => $dateDuJOur,
            'accueilForm' => $accueilForm->createView(),


        ]);
    }
}
