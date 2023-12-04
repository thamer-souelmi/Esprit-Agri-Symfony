<?php

namespace App\Controller;

use App\Entity\Veterinaire;
use App\Form\VeterinaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/veterinaire')]
class VeterinaireController extends AbstractController
{
    #[Route('/', name: 'app_veterinaire_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $veterinaires = $entityManager
            ->getRepository(Veterinaire::class)
            ->findAll();

        return $this->render('veterinaire/index.html.twig', [
            'veterinaires' => $veterinaires,
        ]);
    }

    #[Route('/new', name: 'app_veterinaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $veterinaire = new Veterinaire();
        $form = $this->createForm(VeterinaireType::class, $veterinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($veterinaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veterinaire/new.html.twig', [
            'veterinaire' => $veterinaire,
            'form' => $form,
        ]);
    }

    #[Route('/{idvet}', name: 'app_veterinaire_show', methods: ['GET'])]
    public function show(Veterinaire $veterinaire): Response
    {
        return $this->render('veterinaire/show.html.twig', [
            'veterinaire' => $veterinaire,
        ]);
    }

    #[Route('/{idvet}/edit', name: 'app_veterinaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Veterinaire $veterinaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeterinaireType::class, $veterinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veterinaire/edit.html.twig', [
            'veterinaire' => $veterinaire,
            'form' => $form,
        ]);
    }

    #[Route('/{idvet}', name: 'app_veterinaire_delete', methods: ['POST'])]
    public function delete(Request $request, Veterinaire $veterinaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$veterinaire->getIdvet(), $request->request->get('_token'))) {
            $entityManager->remove($veterinaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_veterinaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
