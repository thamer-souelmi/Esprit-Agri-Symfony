<?php

namespace App\Controller;

use App\Entity\Annoncerecrutement;
use App\Entity\User;
use App\Form\AnnoncerecrutementType;
use App\Repository\AnnoncerecrutementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annoncerecrutement')]
class AnnoncerecrutementController extends AbstractController
{
    #[Route('/', name: 'app_annoncerecrutement_index', methods: ['GET'])]
    public function index(AnnoncerecrutementRepository $annoncerecrutementRepository): Response
    {
        return $this->render('annoncerecrutement/index.html.twig', [
            'annoncerecrutements' => $annoncerecrutementRepository->findAll(),
        ]);
    }

    #[Route('/back', name: 'app_annoncerecrutementback_index', methods: ['GET'])]
    public function indexba(AnnoncerecrutementRepository $annoncerecrutementRepository): Response
    {
        return $this->render('annoncerecrutement/indexback.html.twig', [
            'annoncerecrutements' => $annoncerecrutementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annoncerecrutement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,AnnoncerecrutementRepository $annoncerecrutementRepository): Response
    {
        $user = $entityManager->getRepository(User::class)->find(7);

        $annoncerecrutement = new Annoncerecrutement();
        $currentDate = new \DateTime();
        $annoncerecrutement->setDatepub($currentDate);
        $form = $this->createForm(AnnoncerecrutementType::class, $annoncerecrutement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $annoncerecrutement -> setIduser($user);
            $entityManager->persist($annoncerecrutement);
            $entityManager->flush();
       //     $annoncerecrutementRepository->save($annoncerecrutement, true);
       /*     $this->addFlash(
                'info',
                'Element ajouté avec succès'
            );*/
    
            return $this->redirectToRoute('app_annoncerecrutement_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('annoncerecrutement/new.html.twig', [
            'annoncerecrutement' => $annoncerecrutement,
            'form' => $form,
        ]);
    }
    
    

    #[Route('/{idrecurt}', name: 'app_annoncerecrutement_show', methods: ['GET'])]
    public function show(Annoncerecrutement $annoncerecrutement): Response
    {
        return $this->render('annoncerecrutement/show.html.twig', [
            'annoncerecrutement' => $annoncerecrutement,
        ]);
    }

    #[Route('/{idrecurt}/edit', name: 'app_annoncerecrutement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annoncerecrutement $annoncerecrutement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnoncerecrutementType::class, $annoncerecrutement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annoncerecrutement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annoncerecrutement/edit.html.twig', [
            'annoncerecrutement' => $annoncerecrutement,
            'form' => $form,
        ]);
    }

    #[Route('/{idrecurt}', name: 'app_annoncerecrutement_delete', methods: ['POST'])]
    public function delete(Request $request, Annoncerecrutement $annoncerecrutement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annoncerecrutement->getIdrecurt(), $request->request->get('_token'))) {
            $entityManager->remove($annoncerecrutement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annoncerecrutement_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/search/annoncerecrut', name: 'annoncerecrut_search', methods: ['GET'])]
public function search(Request $request, AnnoncerecrutementRepository $annoncerecrutementRepository): Response
{
    $searchQuery = $request->query->get('search_query');


    $resultats = $annoncerecrutementRepository->searchByPosteContratLoca($searchQuery);

    return $this->render('annoncerecrutement/index.html.twig', [
        'annoncerecrutements' => $resultats,
    ]);
}
#[Route('/back/{id}', name: 'app_annoncerecruback_delete', methods: ['POST'])]
public function deleteback(Request $request, Annoncerecrutement $annoncerecrutement, AnnoncerecrutementRepository $annoncerecrutementRepository): Response
{
    if ($annoncerecrutementRepository->isAnnReInUse($annoncerecrutement)) {
        $this->addFlash('danger', 'L\'annonce a des condidatues obtenue . Suppression impossible.');
    } else {
        if ($this->isCsrfTokenValid('delete' . $annoncerecrutement->getIdrecurt(), $request->request->get('_token'))) {
            $annoncerecrutementRepository->remove($annoncerecrutement, true);
            $this->addFlash('success', 'L\'annonce a été supprimée avec succès.');
        } else {
            $this->addFlash('danger', 'Le jeton CSRF n\'est pas valide. Suppression impossible.');
        }
    }

    return $this->redirectToRoute('app_annoncerecrutementback_index', [], Response::HTTP_SEE_OTHER);
}
}
