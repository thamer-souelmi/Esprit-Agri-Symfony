<?php

namespace App\Controller;

use App\Entity\Bilanresultat;
use App\Form\BilanresultatType;
use App\Repository\BilanresultatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bilanresultat')]
class BilanresultatController extends AbstractController
{
    #[Route('/', name: 'app_bilanresultat_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $bilanresultats = $entityManager
            ->getRepository(Bilanresultat::class)
            ->findAll();

        // Utilisez le composant Paginator pour paginer les résultats
        $pagination = $paginator->paginate(
            $bilanresultats,
            $request->query->getInt('page', 1), // Numéro de la page, par défaut 1
            4 // Nombre d'éléments par page
        );

        return $this->render('bilanresultat/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_bilanresultat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bilanresultat = new Bilanresultat();
        $form = $this->createForm(BilanresultatType::class, $bilanresultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bilanresultat);
            $entityManager->flush();

            return $this->redirectToRoute('app_bilanresultat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilanresultat/new.html.twig', [
            'bilanresultat' => $bilanresultat,
            'form' => $form,
        ]);
    }

    #[Route('/{idbilanr}', name: 'app_bilanresultat_show', methods: ['GET'])]
    public function show(Bilanresultat $bilanresultat, BilanresultatRepository $bilanresultatRepository): Response
    {
        // Calculate the sum of revenuescultures, subvention, and autrerevenus
        $totalRevenus = $bilanresultatRepository->sumOfTotalRevenus($bilanresultat->getIdBilanR());

        // Calculate the sum of production costs
        $productionCosts = $bilanresultatRepository->sumOfProductionCosts($bilanresultat->getIdBilanR());

        // Calculate the sum of operating expenses
        $totalOperatingExpenses = $bilanresultatRepository->sumOfOperatingExpenses($bilanresultat->getIdBilanR());

        return $this->render('bilanresultat/show.html.twig', [
            'bilanresultat' => $bilanresultat,
            'totalRevenus' => $totalRevenus,
            'productionCosts' => $productionCosts,
            'totalOperatingExpenses' => $totalOperatingExpenses,
        ]);
    }

    #[Route('/{idbilanr}/edit', name: 'app_bilanresultat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bilanresultat $bilanresultat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BilanresultatType::class, $bilanresultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bilanresultat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilanresultat/edit.html.twig', [
            'bilanresultat' => $bilanresultat,
            'form' => $form,
        ]);
    }

    #[Route('/{idbilanr}', name: 'app_bilanresultat_delete', methods: ['POST'])]
    public function delete(Request $request, Bilanresultat $bilanresultat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bilanresultat->getIdbilanr(), $request->request->get('_token'))) {
            $entityManager->remove($bilanresultat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bilanresultat_index', [], Response::HTTP_SEE_OTHER);
    }
}
