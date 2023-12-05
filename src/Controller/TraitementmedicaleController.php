<?php

namespace App\Controller;

use App\Entity\Traitementmedicale;
use App\Form\TraitementmedicaleType;
use App\Repository\TraitementmedicaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/traitementmedicale')]
class TraitementmedicaleController extends AbstractController
{
//    #[Route('/', name: 'app_traitementmedicale_index', methods: ['GET'])]
//     public function index(EntityManagerInterface $entityManager): Response
//     {
//         $traitementmedicales = $entityManager
//             ->getRepository(Traitementmedicale::class)
//             ->findAll();

//         return $this->render('traitementmedicale/index.html.twig', [
//             'traitementmedicales' => $traitementmedicales,
//         ]);
//     }

    #[Route('/', name: 'app_traitementmedicale_index', methods: ['GET'])]
    public function index(TraitementmedicaleRepository $traitementmedicaleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $traitementmedicale = $traitementmedicaleRepository->findAll();

        $pagination = $paginator->paginate(
            $traitementmedicale,
            $request->query->getInt('page', 1),
            3 // Number of items per page
        );

        return $this->render('traitementmedicale/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/pdf', name: 'pdf', methods: ['GET'])]
    public function index_pdf(TraitementmedicaleRepository $traitementmedicaleRepository, Request $request): Response
    {
        // Création d'une nouvelle instance de la classe Dompdf
        $dompdf = new Dompdf();

        // Récupération de la liste des événements à partir du repository
        $traitementmedicale = $traitementmedicaleRepository->findAll();
        $imagePath = $this->getParameter('kernel.project_dir') . '/public/img/1.jpeg';
        // Encode the image to base64
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
        // Génération du HTML à partir du template Twig 'evenement/pdf_file.html.twig' en passant la liste des événements
        $html = $this->renderView('traitementmedicale/file_pdf.html.twig', [
            'traitementmedicales' => $traitementmedicale,
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

#[Route('/traitementmedicale/advanced-search', name: 'app_traitementmedicale_advanced_search', methods: ['GET'])]
public function advancedSearch(Request $request)
{
    
    $startDate = $request->query->get('start_date');
        $endDate = $request->query->get('end_date');
        $minCost = $request->query->get('min_cost');
        $maxCost = $request->query->get('max_cost');

        // on appelle repo pour la recherche avance
        $entityManager = $this->getDoctrine()->getManager();
        $traitementMedicaleRepository = $entityManager->getRepository(Traitementmedicale::class);
        $results = $traitementMedicaleRepository->advancedSearch($startDate, $endDate, $minCost, $maxCost);

        // Si la requête est une requête Ajax, retournez une réponse JSON
        if ($request->isXmlHttpRequest()) {
            return $this->json(['results' => $results]);
        }

        // Sinon, retournez la vue Twig normale
        return $this->render('traitementmedicale/advanced_search_results.html.twig', [
            'results' => $results,
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
// statistique back


    #[Route('/graphique/traitements-par-annee', name: 'graphique_traitements_par_annee')]
    public function graphiqueTraitementsParAnnee(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Traitementmedicale::class)->countTraitementsParAnnee();

        return $this->render('traitementmedicale/graphiquetraitementsparannee.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/graphique/traitements-par-veterinaire', name: 'graphique_traitements_par_veterinaire')]
    public function graphiqueTraitementsParVeterinaire(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Traitementmedicale::class)->countTraitementsParVeterinaire();

        // Calcul du nombre total de traitements médicaux
        $totalTraitements = array_reduce($data, function ($carry, $item) {
            return $carry + $item['count'];
        }, 0);

        // Conversion du nombre de traitements en pourcentage
        foreach ($data as &$item) {
            $item['percentage'] = ($totalTraitements > 0) ? ($item['count'] / $totalTraitements) * 100 : 0;
        }
       
        var_dump($data);
        return $this->render('traitementmedicale/graphiquetraitementsparveterinaire.html.twig', [
            'data' => $data,
        ]);
    }
   

}
