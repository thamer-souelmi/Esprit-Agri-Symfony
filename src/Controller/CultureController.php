<?php

namespace App\Controller;

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

#[Route('/culture')]
class CultureController extends AbstractController
{
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

    #[Route('/', name: 'app_culture_index', methods: ['GET'])]
    public function index(CultureRepository $cultureRepository): Response
    {
        return $this->render('culture/index.html.twig', [
            'cultures' => $cultureRepository->findAll(),
        ]);
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

            return $this->redirectToRoute('app_culture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('culture/new.html.twig', [
            'culture' => $culture,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_culture_show', methods: ['GET'])]
    public function show(Culture $culture): Response
    {
        return $this->render('culture/show.html.twig', [
            'culture' => $culture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_culture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Culture $culture, CultureRepository $cultureRepository): Response
    {
        $form = $this->createForm(CultureType::class, $culture, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Your existing logic for saving edited culture
            // ...

            return $this->redirectToRoute('app_culture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('culture/edit.html.twig', [
            'culture' => $culture,
            'form' => $form,
        ]);
    }

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