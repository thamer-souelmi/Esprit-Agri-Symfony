<?php

namespace App\Controller;

use App\Entity\Annonceinvestissement;
use App\Form\AnnonceinvestissementType;
use App\Repository\AnnonceinvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annonceinvestissement')]
class AnnonceinvestissementController extends AbstractController
{
    #[Route('/', name: 'app_annonceinvestissement_index', methods: ['GET'])]
    public function index(AnnonceinvestissementRepository $annonceinvestissementRepository): Response
    {
        return $this->render('annonceinvestissement/index.html.twig', [
            'annonceinvestissements' => $annonceinvestissementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annonceinvestissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonceinvestissement = new Annonceinvestissement();
        $form = $this->createForm(AnnonceinvestissementType::class, $annonceinvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($annonceinvestissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonceinvestissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonceinvestissement/new.html.twig', [
            'annonceinvestissement' => $annonceinvestissement,
            'form' => $form,
        ]);
    }

    #[Route('/{idannonce}', name: 'app_annonceinvestissement_show', methods: ['GET'])]
    public function show(Annonceinvestissement $annonceinvestissement): Response
    {
        return $this->render('annonceinvestissement/show.html.twig', [
            'annonceinvestissement' => $annonceinvestissement,
        ]);
    }

    #[Route('/{idannonce}/edit', name: 'app_annonceinvestissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonceinvestissement $annonceinvestissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnonceinvestissementType::class, $annonceinvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annonceinvestissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonceinvestissement/edit.html.twig', [
            'annonceinvestissement' => $annonceinvestissement,
            'form' => $form,
        ]);
    }

    #[Route('/{idannonce}', name: 'app_annonceinvestissement_delete', methods: ['POST'])]
    public function delete(Request $request, Annonceinvestissement $annonceinvestissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonceinvestissement->getIdannonce(), $request->request->get('_token'))) {
            $entityManager->remove($annonceinvestissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annonceinvestissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
