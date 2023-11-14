<?php

namespace App\Controller;

use App\Entity\Annoncerecrutement;
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

    #[Route('/new', name: 'app_annoncerecrutement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annoncerecrutement = new Annoncerecrutement();
        $currentDate = new \DateTime();
        $annoncerecrutement->setDatepub($currentDate);
    
        $form = $this->createForm(AnnoncerecrutementType::class, $annoncerecrutement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($annoncerecrutement);
            $entityManager->flush();
    
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
}
