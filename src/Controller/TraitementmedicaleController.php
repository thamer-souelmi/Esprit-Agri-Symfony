<?php

namespace App\Controller;

use App\Entity\Traitementmedicale;
use App\Form\TraitementmedicaleType;
use App\Repository\TraitementmedicaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/traitementmedicale')]
class TraitementmedicaleController extends AbstractController
{
    #[Route('/', name: 'app_traitementmedicale_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $traitementmedicales = $entityManager
            ->getRepository(Traitementmedicale::class)
            ->findAll();

        return $this->render('traitementmedicale/index.html.twig', [
            'traitementmedicales' => $traitementmedicales,
        ]);
    }
    #[Route('/traitementback', name: 'app_traitementmedicale_back', methods: ['GET'])]
    public function indexback(EntityManagerInterface $entityManager): Response
    {
        $traitementmedicales = $entityManager
            ->getRepository(Traitementmedicale::class)
            ->findAll();

        return $this->render('traitementmedicale/indexback.html.twig', [
            'traitementmedicales' => $traitementmedicales,
        ]);
    }




    #[Route('/search', name: 'app_traitementmedicale_search', methods: ['GET'])]

    public function searchAction(Request $request, TraitementmedicaleRepository $traitementRepository)
    {
        $searchQuery = $request->get('search_query');

        // Effectuez la recherche en fonction de $searchQuery (utilisez Doctrine ou votre méthode de recherche)
        $results = $traitementRepository->search($searchQuery);
    
    return $this->render('traitementmedicale/search_results.html.twig', [
        'traitementmedicales' => $results,
    ]);
}

    #[Route('/newt', name: 'app_traitementmedicale_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $traitementmedicale = new Traitementmedicale();
        $traitementmedicale->setTypeintervmed('vaccination');

        $form = $this->createForm(TraitementmedicaleType::class, $traitementmedicale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($traitementmedicale);
            $entityManager->flush();

            return $this->redirectToRoute('app_traitementmedicale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('traitementmedicale/new.html.twig', [
            'traitementmedicale' => $traitementmedicale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_traitementmedicale_show', methods: ['GET'])]
    public function show(Traitementmedicale $traitementmedicale, TraitementmedicaleRepository $repository): Response
    {
         // Récupérez le numéro de traitement pour ce traitement spécifique
         $numeroTraitement = $traitementmedicale->getNumero();

         // Utilisez la fonction compterTraitementsParNumero pour obtenir le nombre de traitements
         $nombreTraitementsMedicaux = $repository->compterTraitementsParNumero($numeroTraitement);
 
        return $this->render('traitementmedicale/show.html.twig', [
            'traitementmedicale' => $traitementmedicale,
            'nombreTraitementsMedicaux' => $nombreTraitementsMedicaux,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_traitementmedicale_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Traitementmedicale $traitementmedicale, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TraitementmedicaleType::class, $traitementmedicale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_traitementmedicale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('traitementmedicale/edit.html.twig', [
            'traitementmedicale' => $traitementmedicale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_traitementmedicale_delete', methods: ['POST'])]
    public function delete(Request $request, Traitementmedicale $traitementmedicale, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$traitementmedicale->getId(), $request->request->get('_token'))) {
            $entityManager->remove($traitementmedicale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_traitementmedicale_index', [], Response::HTTP_SEE_OTHER);
    }



   
}
