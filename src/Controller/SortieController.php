<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Etat;
use App\Entity\Sortie;
use App\Entity\Utilisateur;
use App\Form\ListeSortieType;
use App\Form\SortieType;
use App\Form\AnnulerSortieType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $user = $this->getUser();
            $sortie->setOrganisateur($user);
            $etat = $etatRepository->find(1);
            $sortie->setEtat($etat);

            if ($sortieForm->get('enregistrer')->isClicked()) {
                $etat = $etatRepository->find(1);
                $sortie->setEtat($etat);
                $entityManager->persist($sortie);
                $entityManager->flush();
                $this->addFlash('success', 'Une Sortie est créée !');
                return $this->redirectToRoute('sortie_create');
            }
            if ($sortieForm->get('publier')->isClicked()) {
                $etat = $etatRepository->find(2);
                $sortie->setEtat($etat);
                $entityManager->persist($sortie);
                $entityManager->flush();
                $this->addFlash('success', 'Une Sortie est publiée !');
            }
        }
        return $this->render('sortie/create.html.twig', [
            'controller_name' => 'SortieController',
            'sortieForm' => $sortieForm->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/sortie/{id}", name="sortie_details", requirements={"id":"\d+"})
     */
    public function details(int $id, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $repository = $entityManager->getRepository(sortie::class);
        $sortie = $repository->find($id);
        return $this->render('sortie/details.html.twig', [
            'sortie' => $sortie,
            'user' => $user,
        ]);

    }

    /**
     * @Route("/", name="sortie_accueil")
     */

    public function accueil(SortieRepository $repository, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $data = new SearchData();
        $dateDuJOur = new \DateTime;
        $dateArchive = new \DateTime;
        $dateArchive->sub(new \DateInterval('P1M'));
        $accueilForm = $this->createForm(ListeSortieType::class, $data);
        $accueilForm->handleRequest($request);
        $sorties = $repository->findSearch($data, $user);


        return $this->render('sortie/accueil.html.twig', [
            'user' => $user,
            'dateArchive' => $dateArchive,
            'sorties' => $sorties,
            'dateDuJOur' => $dateDuJOur,
            'accueilForm' => $accueilForm->createView(),

        ]);
    }

    /**
     * @Route("/sortie/modifier/{id}", name="sortie_modifier")
     *
     */
    public function modifier(Request $request, $id, EntityManagerInterface $entityManager, EtatRepository $etatRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $repository = $entityManager->getRepository(sortie::class);
        $sortie = $repository->find($id);

        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

            if ($sortieForm->get('enregistrer')->isClicked()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Cette Sortie est Modifiée !');
                return $this->redirectToRoute('sortie_accueil');
            }
            if ($sortieForm->get('publier')->isClicked()) {
                $etat = $etatRepository->find(2);
                $sortie->setEtat($etat);
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Cette Sortie est Modifiée !');
                return $this->redirectToRoute('sortie_accueil');
            }

        }
        return $this->render('sortie/modifier.html.twig', [
            'user' => $user,
            'sortie' => $sortie,
            'sortieForm' => $sortieForm->createView(),
        ]);
    }

    /**
     * @Route("/sortie/annuler/{id}", name="sortie_annuler")
     */
    public function annuler(Request $request, $id, EntityManagerInterface $entityManager, EtatRepository $etatRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $sortie = new Sortie();
        $repository = $entityManager->getRepository(sortie::class);
        $sortie = $repository->find($id);
        $AnnulerSortieForm = $this->createForm(AnnulerSortieType::class, $sortie);
        $AnnulerSortieForm->handleRequest($request);

        if ($AnnulerSortieForm->isSubmitted() && $AnnulerSortieForm->isValid()) {
            $etat = $etatRepository->find(6);
            $sortie->setEtat($etat);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Cette Sortie est Annulée !');
            return $this->redirectToRoute('sortie_accueil');
        }
        return $this->render('sortie/annuler.html.twig', [
            'user' => $user,
            'sortie' => $sortie,
            'AnnulerSortieForm' => $AnnulerSortieForm->createView(),
        ]);
    }

    /**
     * @Route("/utilisateurinscrit/{id}", name="inscrire_utilisateur")
     * @param EntityManagerInterface $em
     * @param $id
     * @param $entitymanager
     * @return Response
     */
    public function inscrireUtilisateur(EntityManagerInterface $em, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        $participant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($this->getUser());
        $Sortie->addParticipant($participant);
        $em->persist($Sortie);
        $em->flush();
        $this->addFlash('success', 'Inscription confirmée !');
        return $this->redirectToRoute('sortie_accueil');
    }

    /**
     * @Route("/utilisateur_desistement/{id}", name="desistement_utilisateur")
     */
    public function seDesister(EntityManagerInterface $em, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        $participant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($this->getUser());
        $Sortie->removeParticipant($participant);
        $em->persist($Sortie);
        $em->flush();

        $this->addFlash('success', 'Participation à la sortie annulée !');

        return $this->redirectToRoute('sortie_accueil');

    }

  }
