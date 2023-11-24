<?php

namespace App\Controller;

use App\Entity\Negociation;
use App\Form\NegociationType;
use App\Repository\NegociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/negociation')]
class NegociationController extends AbstractController
{
    #[Route('/', name: 'app_negociation_index', methods: ['GET'])]
    public function index(NegociationRepository $negociationRepository): Response
    {
        return $this->render('negociation/index.html.twig', [
            'negociations' => $negociationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_negociation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $negociation = new Negociation();
        $form = $this->createForm(NegociationType::class, $negociation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($negociation);
            $entityManager->flush();

            return $this->redirectToRoute('app_negociation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('negociation/new.html.twig', [
            'negociation' => $negociation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_negociation_show', methods: ['GET'])]
    public function show(Negociation $negociation): Response
    {
        return $this->render('negociation/show.html.twig', [
            'negociation' => $negociation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_negociation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Negociation $negociation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NegociationType::class, $negociation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_negociation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('negociation/edit.html.twig', [
            'negociation' => $negociation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_negociation_delete', methods: ['POST'])]
    public function delete(Request $request, Negociation $negociation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$negociation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($negociation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_negociation_index', [], Response::HTTP_SEE_OTHER);
    }
}
