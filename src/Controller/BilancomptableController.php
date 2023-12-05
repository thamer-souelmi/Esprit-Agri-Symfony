<?php

namespace App\Controller;

use App\Entity\Bilancomptable;
use App\Form\BilancomptableType;
use App\Repository\BilancomptableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;
use Mpdf\Mpdf;
use Dompdf\Dompdf;


#[Route('/bilancomptable')]
class BilancomptableController extends AbstractController
{
    #[Route('/', name: 'app_bilancomptable_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $bilancomptables = $entityManager
            ->getRepository(Bilancomptable::class)
            ->findAll();

        // Utilisez le composant Paginator pour paginer les résultats
        $pagination = $paginator->paginate(
            $bilancomptables,
            $request->query->getInt('page', 1), // Numéro de la page, par défaut 1
            4 // Nombre d'éléments par page
        );

        return $this->render('bilancomptable/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_bilancomptable_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Security $security): Response
    {
        $bilancomptable = new Bilancomptable();
        $user = $security->getUser();
        $bilancomptable->setUser($user);
        $form = $this->createForm(BilancomptableType::class, $bilancomptable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bilancomptable);
            $entityManager->flush();

            return $this->redirectToRoute('app_bilancomptable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilancomptable/new.html.twig', [
            'bilancomptable' => $bilancomptable,
            'form' => $form,
        ]);
    }

    #[Route('/{idbilanc}', name: 'app_bilancomptable_show', methods: ['GET'])]
    public function show(Bilancomptable $bilancomptable, BilancomptableRepository $bilancomptableRepository): Response
    {
        $totalActifImmobilise = $bilancomptableRepository->sumOfValues($bilancomptable->getIdbilanc());
        $totalActifCirculant = $bilancomptableRepository->sumOfTotalActifCirculant($bilancomptable->getIdbilanc());
        $totalCapitauxPropres = $bilancomptableRepository->sumOfTotalCapitauxPropres($bilancomptable->getIdbilanc());
        $totalDettesLongTerme = $bilancomptableRepository->sumOfTotalDettesLongTerme($bilancomptable->getIdbilanc());
        $totalDettesCourtTerme = $bilancomptableRepository->sumOfTotalDettesCourtTerme($bilancomptable->getIdbilanc());

        return $this->render('bilancomptable/show.html.twig', [
            'bilancomptable' => $bilancomptable,
            'totalActifImmobilise' => $totalActifImmobilise,
            'totalActifCirculant' => $totalActifCirculant,
            'totalCapitauxPropres' => $totalCapitauxPropres,
            'totalDettesLongTerme' => $totalDettesLongTerme,
            'totalDettesCourtTerme' => $totalDettesCourtTerme,
        ]);
    }

    #[Route('/{idbilanc}/edit', name: 'app_bilancomptable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bilancomptable $bilancomptable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BilancomptableType::class, $bilancomptable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bilancomptable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilancomptable/edit.html.twig', [
            'bilancomptable' => $bilancomptable,
            'form' => $form,
        ]);
    }

    #[Route('/{idbilanc}', name: 'app_bilancomptable_delete', methods: ['POST'])]
    public function delete(Request $request, Bilancomptable $bilancomptable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bilancomptable->getIdbilanc(), $request->request->get('_token'))) {
            $entityManager->remove($bilancomptable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bilancomptable_index', [], Response::HTTP_SEE_OTHER);
    }
    ////////////////////////////pdf////////////////////////////////
    /*#[Route('/generate-pdf/{idbilanc}', name: 'generate_pdf', methods: ['GET'])]
    public function generatePdf($idbilanc, BilancomptableRepository $bilancomptableRepository): Response
    {
        $dompdf = new Dompdf();
        // Fetch your data here, replace this with your actual data fetching logic
        $bilancomptable = $bilancomptableRepository->find($idbilanc);
        $totalActifImmobilise = $bilancomptableRepository->sumOfValues($bilancomptable->getIdbilanc());
        $totalActifCirculant = $bilancomptableRepository->sumOfTotalActifCirculant($bilancomptable->getIdbilanc());
        $totalCapitauxPropres = $bilancomptableRepository->sumOfTotalCapitauxPropres($bilancomptable->getIdbilanc());
        $totalDettesLongTerme = $bilancomptableRepository->sumOfTotalDettesLongTerme($bilancomptable->getIdbilanc());
        $totalDettesCourtTerme = $bilancomptableRepository->sumOfTotalDettesCourtTerme($bilancomptable->getIdbilanc());
        // Add other variables as needed

        // Render the Twig template
        $html = $this->renderView('bilancomptable/pdf_file.html.twig', [
            'bilancomptable' => $bilancomptable,
            'totalActifImmobilise' => $totalActifImmobilise,
            'totalActifCirculant' => $totalActifCirculant,
            'totalCapitauxPropres' => $totalCapitauxPropres,
            'totalDettesLongTerme' => $totalDettesLongTerme,
            'totalDettesCourtTerme' => $totalDettesCourtTerme,
        ]);
        // Récupération des options de Dompdf et activation du chargement des ressources à distance
        $options = $dompdf->getOptions();
        $options->set([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,  // Enable PHP rendering
        ]);

        $dompdf->setOptions($options);

        // Create a PDF using mPDF library
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output the PDF as a response
        return new Response($mpdf->Output(), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }*/
    #[Route('/generate-pdf/{idbilanc}', name: 'generate_pdf', methods: ['GET'])]
    public function index_pdf(BilancomptableRepository $bilancomptableRepository, Request $request,$idbilanc,Bilancomptable $bilancomptable): Response
    {
        // Création d'une nouvelle instance de la classe Dompdf
        $dompdf = new Dompdf();

        // Récupération de la liste des événements à partir du repository
        $totalActifImmobilise = $bilancomptableRepository->sumOfValues($bilancomptable->getIdbilanc());
        $totalActifCirculant = $bilancomptableRepository->sumOfTotalActifCirculant($bilancomptable->getIdbilanc());
        $totalCapitauxPropres = $bilancomptableRepository->sumOfTotalCapitauxPropres($bilancomptable->getIdbilanc());
        $totalDettesLongTerme = $bilancomptableRepository->sumOfTotalDettesLongTerme($bilancomptable->getIdbilanc());
        $totalDettesCourtTerme = $bilancomptableRepository->sumOfTotalDettesCourtTerme($bilancomptable->getIdbilanc());
        $imagePath = $this->getParameter('kernel.project_dir') . '/public/img/logoespritAgri.png';
        // Encode the image to base64
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;
        // Génération du HTML à partir du template Twig 'evenement/pdf_file.html.twig' en passant la liste des événements
        $html = $this->renderView('bilancomptable/pdf_file.html.twig', [
            'bilancomptable' => $bilancomptable,
            'totalActifImmobilise' => $totalActifImmobilise,
            'totalActifCirculant' => $totalActifCirculant,
            'totalCapitauxPropres' => $totalCapitauxPropres,
            'totalDettesLongTerme' => $totalDettesLongTerme,
            'totalDettesCourtTerme' => $totalDettesCourtTerme,
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
    ///////////////////////////////////EURO///////////////////////////////////////////
    #[Route('/{idbilanc}/euro', name: 'app_bilancomptable_show_euro', methods: ['GET'])]
    public function showEURO(Bilancomptable $bilancomptable, BilancomptableRepository $bilancomptableRepository): Response
    {
        $totalActifImmobilise = $bilancomptableRepository->sumOfValues($bilancomptable->getIdbilanc());
        $totalActifCirculant = $bilancomptableRepository->sumOfTotalActifCirculant($bilancomptable->getIdbilanc());
        $totalCapitauxPropres = $bilancomptableRepository->sumOfTotalCapitauxPropres($bilancomptable->getIdbilanc());
        $totalDettesLongTerme = $bilancomptableRepository->sumOfTotalDettesLongTerme($bilancomptable->getIdbilanc());
        $totalDettesCourtTerme = $bilancomptableRepository->sumOfTotalDettesCourtTerme($bilancomptable->getIdbilanc());

        return $this->render('bilancomptable/showEURO.html.twig', [
            'bilancomptable' => $bilancomptable,
            'totalActifImmobilise' => $totalActifImmobilise,
            'totalActifCirculant' => $totalActifCirculant,
            'totalCapitauxPropres' => $totalCapitauxPropres,
            'totalDettesLongTerme' => $totalDettesLongTerme,
            'totalDettesCourtTerme' => $totalDettesCourtTerme,
        ]);
    }
    //////////////////////////////////DOLLAR///////////////////////////////////////////////////
    #[Route('/{idbilanc}/dollar', name: 'app_bilancomptable_show_usd', methods: ['GET'])]
    public function showUSD(Bilancomptable $bilancomptable, BilancomptableRepository $bilancomptableRepository): Response
    {
        $totalActifImmobilise = $bilancomptableRepository->sumOfValues($bilancomptable->getIdbilanc());
        $totalActifCirculant = $bilancomptableRepository->sumOfTotalActifCirculant($bilancomptable->getIdbilanc());
        $totalCapitauxPropres = $bilancomptableRepository->sumOfTotalCapitauxPropres($bilancomptable->getIdbilanc());
        $totalDettesLongTerme = $bilancomptableRepository->sumOfTotalDettesLongTerme($bilancomptable->getIdbilanc());
        $totalDettesCourtTerme = $bilancomptableRepository->sumOfTotalDettesCourtTerme($bilancomptable->getIdbilanc());

        return $this->render('bilancomptable/showUSD.html.twig', [
            'bilancomptable' => $bilancomptable,
            'totalActifImmobilise' => $totalActifImmobilise,
            'totalActifCirculant' => $totalActifCirculant,
            'totalCapitauxPropres' => $totalCapitauxPropres,
            'totalDettesLongTerme' => $totalDettesLongTerme,
            'totalDettesCourtTerme' => $totalDettesCourtTerme,
        ]);
    }
    
}


