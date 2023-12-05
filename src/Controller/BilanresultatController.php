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
use Symfony\Component\Security\Core\Security;
use Mpdf\Mpdf;
use Dompdf\Dompdf;

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
    public function new(Request $request, EntityManagerInterface $entityManager,Security $security): Response
    {
        $bilanresultat = new Bilanresultat();
        $user = $security->getUser();
        $bilanresultat->setUser($user);
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
    #[Route('/generate-pdf/{idbilanr}', name: 'generate_pdf_R', methods: ['GET'])]
    public function index_pdf(BilanresultatRepository $bilanresultatRepository,Bilanresultat $bilanresultat, Request $request,$idbilanr): Response
    {
        // Création d'une nouvelle instance de la classe Dompdf
        $dompdf = new Dompdf();

        // Récupération de la liste des événements à partir du repository
        // Calculate the sum of revenuescultures, subvention, and autrerevenus
        $totalRevenus = $bilanresultatRepository->sumOfTotalRevenus($bilanresultat->getIdBilanR());

        // Calculate the sum of production costs
        $productionCosts = $bilanresultatRepository->sumOfProductionCosts($bilanresultat->getIdBilanR());

        // Calculate the sum of operating expenses
        $totalOperatingExpenses = $bilanresultatRepository->sumOfOperatingExpenses($bilanresultat->getIdBilanR());
        $imagePath = $this->getParameter('kernel.project_dir') . '/public/img/logoespritAgri.png';
        // Encode the image to base64
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;
        // Génération du HTML à partir du template Twig 'evenement/pdf_file.html.twig' en passant la liste des événements
        $html = $this->renderView('bilanresultat/pdf_file.html.twig', [
            'bilanresultat' => $bilanresultat,
            'totalRevenus' => $totalRevenus,
            'productionCosts' => $productionCosts,
            'totalOperatingExpenses' => $totalOperatingExpenses,
            'imagePath' => $imageSrc,

        ]);

        // Récupération des options de Dompdf et activation du chargement des ressources à distance
        $options = $dompdf->getOptions();
        $options->set([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,  // Enable PHP rendering
        ]);

        $dompdf->setOptions($options);

        // Chargement du HTML généré dans Dompdf
        $dompdf->loadHtml($html);

        // Configuration du format de la page en A4 en mode portrait
        $dompdf->setPaper('A4', 'portrait');

        // Génération du PDF
        $dompdf->render();

        // Récupération du contenu du PDF généré
        $output = $dompdf->output();

        // Set headers for PDF download
        $response = new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="list.pdf"',
        ]);

        return $response;
    }

    /////////////////////////////////////EURO///////////////////////////////////////
    #[Route('/{idbilanr}/euro', name: 'app_bilanresultat_show_euro', methods: ['GET'])]
    public function showEURO(Bilanresultat $bilanresultat, BilanresultatRepository $bilanresultatRepository): Response
    {
        // Calculate the sum of revenuescultures, subvention, and autrerevenus
        $totalRevenus = $bilanresultatRepository->sumOfTotalRevenus($bilanresultat->getIdBilanR());

        // Calculate the sum of production costs
        $productionCosts = $bilanresultatRepository->sumOfProductionCosts($bilanresultat->getIdBilanR());

        // Calculate the sum of operating expenses
        $totalOperatingExpenses = $bilanresultatRepository->sumOfOperatingExpenses($bilanresultat->getIdBilanR());

        return $this->render('bilanresultat/showEURO.html.twig', [
            'bilanresultat' => $bilanresultat,
            'totalRevenus' => $totalRevenus,
            'productionCosts' => $productionCosts,
            'totalOperatingExpenses' => $totalOperatingExpenses,
        ]);
    }
    /////////////////////////////////////DOLLAR///////////////////////////////////////
    #[Route('/{idbilanr}/usd', name: 'app_bilanresultat_show_usd', methods: ['GET'])]
    public function showUSD(Bilanresultat $bilanresultat, BilanresultatRepository $bilanresultatRepository): Response
    {
        // Calculate the sum of revenuescultures, subvention, and autrerevenus
        $totalRevenus = $bilanresultatRepository->sumOfTotalRevenus($bilanresultat->getIdBilanR());

        // Calculate the sum of production costs
        $productionCosts = $bilanresultatRepository->sumOfProductionCosts($bilanresultat->getIdBilanR());

        // Calculate the sum of operating expenses
        $totalOperatingExpenses = $bilanresultatRepository->sumOfOperatingExpenses($bilanresultat->getIdBilanR());

        return $this->render('bilanresultat/showUSD.html.twig', [
            'bilanresultat' => $bilanresultat,
            'totalRevenus' => $totalRevenus,
            'productionCosts' => $productionCosts,
            'totalOperatingExpenses' => $totalOperatingExpenses,
        ]);
    }
}
