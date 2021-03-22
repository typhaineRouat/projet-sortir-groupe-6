<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Sortie;
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
     * @Route("/", name="sortie_accueil")
     */

    public function accueil(SortieRepository $repository, Request $request)
    {

        $data = new SearchData();
        $dateDuJOur = new \DateTime;
        $accueilForm = $this->createForm(SortieType::class, $data);
        $accueilForm->handleRequest($request);
        $sorties = $repository->findSearch($data);



        return $this->render('sortie/accueil.html.twig', [
            'sorties' => $sorties,
            'dateDuJOur' => $dateDuJOur,
            'accueilForm' => $accueilForm->createView(),

        ]);
    }

    /**
     * @Route("/create", name="sortie_create")
     */
    public function create(): Response
    {

        return $this->render('sortie/create.html.twig', [

        ]);
    }

}
