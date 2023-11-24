<?php

namespace App\Controller;

use App\Entity\Veterinaire;
use App\Form\VeterinaireType;
use App\Repository\VeterinaireRepository;
use App\Service\GeocodingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/veterinaire')]
class VeterinaireController extends AbstractController
{
    #[Route('/', name: 'app_veterinaire_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $veterinaires = $entityManager
            ->getRepository(Veterinaire::class)
            ->findAll();

        return $this->render('veterinaire/indexv.html.twig', [
            'veterinaires' => $veterinaires,
        ]);
    }
    


    #[Route('/vet', name: 'frontaffich', methods: ['GET'])]
    public function frontvet(EntityManagerInterface $entityManager): Response
    {
        $veterinaires = $entityManager
            ->getRepository(Veterinaire::class)
            ->findAll();

        return $this->render('veterinaire/index.html.twig', [
            'veterinaires' => $veterinaires,
        ]);
    }

    #[Route('/vetcontact/{id}', name: 'contactvet', methods: ['GET'])]
    public function contactVet($id, VeterinaireRepository $veterinaireRepository)
{
    $veterinaire = $veterinaireRepository->find($id);

    return $this->render('veterinaire/contact.html.twig', [
        'veterinaire' => $veterinaire,
    ]);
}
#[Route('/search/veterinaire', name: 'veterinaire_search', methods: ['GET'])]
public function search(Request $request, VeterinaireRepository $veterinaireRepository): Response
{
    $searchQuery = $request->query->get('search_query');


    $resultats = $veterinaireRepository->searchByNomPrenomAdresse($searchQuery);

    return $this->render('veterinaire/search_results.html.twig', [
        'veterinaires' => $resultats,
    ]);
}


    #[Route('/new', name: 'app_veterinaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $veterinaire = new Veterinaire();
        $form = $this->createForm(VeterinaireType::class, $veterinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('specialite')->getData();
        
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                // Move the file to the directory where your images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle the exception if something happens during the file upload
                }
    
                // Update the 'image' property to store the file name instead of its contents
                $veterinaire->setSpecialite($newFilename);
            }
            
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

/*
    #[Route('/{idvettgeo}', name: 'app_geo')]
public function yourAction(GeocodingService $geocodingService, VeterinaireRepository $veterinaireRepository, int $idvettgeo): Response
{
    // Assuming $veterinaire is your veterinarian entity
    $veterinaire = $veterinaireRepository->find($idvettgeo);

    if (!$veterinaire) {
        throw $this->createNotFoundException('Veterinaire not found');
    }

    $address = $veterinaire->getAdresscabinet();

    // Call the geocoding service to get coordinates
    $coordinates = $geocodingService->getCoordinates($address);

    // Render the contact.html.twig template with the coordinates
    return $this->render('veterinaire/contact.html.twig', [
        'veterinaire' => $veterinaire,
        'coordinates' => $coordinates,
    ]);
}
*/
}
