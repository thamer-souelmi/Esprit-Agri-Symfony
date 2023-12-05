<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Culture;
use App\Form\CultureType;
use App\Repository\CultureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Dompdf\Dompdf;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use UltraMsg\WhatsAppApi;
#[Route('/culture')]
class CultureController extends AbstractController
{



    //composer require dompdf/dompdf
    #[Route('/pdf', name: 'pdf', methods: ['GET'])]
    public function index_pdf(CultureRepository $cultureRepository, Request $request): Response
    {
        // Création d'une nouvelle instance de la classe Dompdf
        $dompdf = new Dompdf();

        // Récupération de la liste des événements à partir du repository
        $cultures = $cultureRepository->findAll();
        $imagePath = $this->getParameter('kernel.project_dir') . '/public/img/1.jpeg';
        // Encode the image to base64
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
        // Génération du HTML à partir du template Twig 'evenement/pdf_file.html.twig' en passant la liste des événements
        $html = $this->renderView('culture/pdf_file.html.twig', [
            'cultures' => $cultures,
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



    #[Route('/searchculture', name: 'searchculture', methods: ['GET', 'POST'])]
    public function searchCulture(Request $request, CultureRepository $cultureRepository): JsonResponse
    {
        // Get the EntityManager instance from Doctrine
        $entityManager = $this->getDoctrine()->getManager();

        // Get the "q" parameter from the request, sent via GET or POST
        $requestString = $request->get('q');

        // Call the findEntitiesByString method of CultureRepository to find cultures matching the query
        $cultures = $cultureRepository->findEntitiesByString($requestString);

        // Check if no cultures were found
        if (!$cultures) {
            $result['cultures']['error'] = "Pas de cultures ! 🙁 ";
        } else {
            // Call the getRealEntities method to format the found cultures into an array understandable for the user
            $result['cultures'] = $this->getRealEntities($cultures);
        }

        // Return a JSON response containing the search results
        return new JsonResponse($result);
    }


    // Your existing code for PDF generation

    #[Route('/calendrier', name: 'calendrier_culture', methods: ['GET'])]
    public function calendrier(CultureRepository $cultureRepository)
    {
        // Your existing code for generating the calendar
    }

    // #[Route('/Front', name: 'app_culture_front', methods: ['GET'])]
    // public function showCultures(Request $request, PaginatorInterface $paginator, CultureRepository $cultureRepository): Response
    // {
    //     $query = $cultureRepository->findAll();

    //     $cultures = $paginator->paginate(
    //         $query,
    //         $request->query->getInt('page', 1),
    //         3
    //     );

    //     return $this->render('culture/showCultures.html.twig', ['cultures' => $cultures]);
    // }

    // #[Route('/', name: 'app_culture_index', methods: ['GET'])]
    // public function index(CultureRepository $cultureRepository): Response
    // {
    //     return $this->render('culture/index.html.twig', [
    //         'cultures' => $cultureRepository->findAll(),
    //     ]);
    // }
    #[Route('/', name: 'app_culture_index', methods: ['GET'])]
    public function index(CultureRepository $cultureRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $cultures = $cultureRepository->findAll();

        $pagination = $paginator->paginate(
            $cultures,
            $request->query->getInt('page', 1),
            3 // Number of items per page
        );

        return $this->render('culture/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/what', name: 'whatsapp')]
    public function envoyerMessageWhatsApp($user, $Type): Response
    {
        require_once __DIR__ . '/../../vendor/autoload.php'; // Make sure the path is correct
        $ultramsg_token = "xlvw4dz9wcdxk5pi"; // Your Ultramsg token
        $instance_id = "instance69768"; // Your Ultramsg instance ID
    
        $client = new WhatsAppApi($ultramsg_token, $instance_id);
    
        $to = "+21652474552"; // Recipient's phone number
        $body = "Nous avons le plaisir de vous informer qu'un agriculteur $user a ajouté une nouvelle culture:$Type dans notre système.";
    
        // Send a text message
        $api = $client->sendChatMessage($to, $body);
    
        // Send an image message
        $image = "https://st2.depositphotos.com/6330084/9169/i/950/depositphotos_91694566-stock-photo-flooded-rice-paddy.jpg";
        $caption = "Image Caption";
        $priority = 10;
        $referenceId = "SDK";
        $nocache = false;
        $imageApi = $client->sendImageMessage($to, $image, $caption, $priority, $referenceId, $nocache);
    
        print_r($api); // Handle the response as needed for the text message
        print_r($imageApi); // Handle the response for the image message
    
        // You can manage the responses as desired, for example, display them
        return new Response('WhatsApp messages sent successfully!');
    }

    #[Route('/new', name: 'app_culture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CultureRepository $cultureRepository, SluggerInterface $slugger): Response
    {
        $culture = new Culture();
        $form = $this->createForm(CultureType::class, $culture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'image' field is not required
            // so the image file must be processed only when a file is uploaded
            // if ($imageFile) {
            //     $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            //     // this is needed to safely include the file name as part of the URL
            //     $safeFilename = $slugger->slug($originalFilename);
            //     $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            // Move the file to the directory where images are stored
            // try {
            //     $imageFile->move(
            //         $this->getParameter('image_directory'),
            //         $newFilename
            //     );
            // } catch (FileException $e) {
            //     // handle exception if something happens during file upload
            //     dd("Error during file upload: " . $e->getMessage());
            // }

            // updates the 'image' property to store the file name
            // $culture->setImage($newFilename);
            //}

            $cultureRepository->save($culture, true);

            $user ="Hamza"; // Remplacez par la méthode réelle pour obtenir le nom de l'utilisateur
            $Type = $culture->getCategorytype();
        
            // Appel à la fonction pour envoyer le message WhatsApp avec les données
            $this->envoyerMessageWhatsApp($user,$Type);

            return $this->redirectToRoute('app_culture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('culture/new.html.twig', [
            'culture' => $culture,
            'form' => $form,
        ]);
    }

    //partie back
    #[Route('/back', name: 'app_cultureback_index', methods: ['GET'])]
    public function indexback(CultureRepository $cultureRepository): Response
    {

        $categorycultureCounts = $cultureRepository->getCategoryCultureCounts();

        return $this->render('culture/indexback.html.twig', [
            'cultures' => $cultureRepository->findAll(), 'categorycultureCounts' => $categorycultureCounts,
        ]);
    }
    #[Route('/back/{id}', name: 'app_cultureback_delete', methods: ['POST'])]
    public function deleteback(Request $request, Culture $culture, CultureRepository $cultureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $culture->getId(), $request->request->get('_token'))) {
            $cultureRepository->remove($culture);
        }

        return $this->redirectToRoute('app_cultureback_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/new/back', name: 'app_cultureback_new', methods: ['GET', 'POST'])]
    public function newback(Request $request, CultureRepository $cultureRepository, SluggerInterface $slugger): Response
    {
        $culture = new Culture();
        $form = $this->createForm(CultureType::class, $culture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $revenuesCultures = $form->get('revenuescultures')->getData();

            // Check if revenues are negative
            if ($revenuesCultures < 0) {
                $this->addFlash('danger', 'Les revenus des cultures ne peuvent pas être négatifs.');
                return $this->redirectToRoute('app_cultureback_new');
            }
            $cultureRepository->save($culture, true);

            return $this->redirectToRoute('app_cultureback_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('culture/newback.html.twig', [
            'culture' => $culture,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edit/back', name: 'app_cultureback_edit', methods: ['GET', 'POST'])]
    public function editback(Request $request, Culture $culture, CultureRepository $cultureRepository): Response
    {
        $form = $this->createForm(CultureType::class, $culture, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Your existing logic for saving edited culture
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($culture);
            $entityManager->flush();

            $this->addFlash('success', 'Culture updated successfully!');

            return $this->redirectToRoute('app_cultureback_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('culture/editback.html.twig', [
            'culture' => $culture,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/back', name: 'app_cultureback_show', methods: ['GET'])]
    public function showback(Culture $culture): Response
    {
        return $this->render('culture/showback.html.twig', [
            'culture' => $culture,
        ]);
    }
    //partie back
    #[Route('/{id}', name: 'app_culture_show', methods: ['GET'])]
    public function show(Culture $culture): Response
    {
        return $this->render('culture/show.html.twig', [
            'culture' => $culture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_culture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, CultureRepository $cultureRepository): Response
    {
        // Fetch the existing Culture object based on the provided id
        $culture = $cultureRepository->find($id);

        // Check if the Culture object was found
        if (!$culture) {
            throw $this->createNotFoundException('Culture not found for id ' . $id);
        }

        // Create the form using the existing Culture object
        $form = $this->createForm(CultureType::class, $culture, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Your existing logic for saving edited culture
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush(); // No need to persist again since the object is already managed

            $this->addFlash('success', 'Culture updated successfully!');

            return $this->redirectToRoute('app_culture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('culture/edit.html.twig', [
            'culture' => $culture,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_culture_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Culture $culture, CultureRepository $cultureRepository): Response
    // {
    //     $form = $this->createForm(CultureType::class, $culture, ['is_edit' => true]);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // Your existing logic for saving edited culture
    //         // ...

    //         return $this->redirectToRoute('app_culture_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('culture/edit.html.twig', [
    //         'culture' => $culture,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_culture_delete', methods: ['POST'])]
    public function delete(Request $request, Culture $culture, CultureRepository $cultureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $culture->getId(), $request->request->get('_token'))) {
            $cultureRepository->remove($culture);
        }

        return $this->redirectToRoute('app_culture_index', [], Response::HTTP_SEE_OTHER);
    }

    public function getRealEntities($cultures)
    {
        $realEntities = [];

        // Loop through the provided Culture entities to create a formatted array
        foreach ($cultures as $culture) {
            $category = $culture->getCategory();

            $realEntities[$culture->getId()] = [
                $culture->getId(),
                $culture->getLibelle(),
                $culture->getDateplantation() ? $culture->getDateplantation()->format('Y-m-d') : null,
                $culture->getDaterecolte() ? $culture->getDaterecolte()->format('Y-m-d') : null,
                $culture->getCategorytype(),
                $culture->getRevenuescultures(),
                $culture->getCoutsplantations(),
                $category ? $category->getType() : null, // Include the category type or null if not available
            ];
        }

        // Return the formatted array
        return $realEntities;
    }
}
