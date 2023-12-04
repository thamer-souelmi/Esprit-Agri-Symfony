<?php

namespace App\Controller;

use App\Entity\Annoncerecrutement;
use App\Entity\Candidature;
use App\Entity\Ouvrier;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use App\Repository\AnnoncerecrutementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Knp\Component\Pager\PaginatorInterface;




#[Route('/candidature')]
class CandidatureController extends AbstractController
{
    #[Route('/', name: 'app_candidature_index', methods: ['GET'])]
    public function index(CandidatureRepository $candidatureRepository, TokenStorageInterface $tokenStorage, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;
    
        if ($user) {
            $candidatures = $candidatureRepository->findBy(['archived' => false, 'statuscandidature' => false, 'user' => $user]);
        } else {
            // Utilisateur non authentifié, peut-être rediriger vers une page de connexion
            // ou simplement afficher toutes les candidatures non archivées et non acceptées
            $candidatures = $candidatureRepository->findBy(['archived' => false, 'statuscandidature' => false]);
        }
    
        $pagination = $paginator->paginate(
            $candidatures,
            $request->query->getInt('page', 1),
            6 // Nombre d'éléments par page
        );
    
        return $this->render('candidature/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    
    #[Route('/back', name: 'app_candidatureback_index', methods: ['GET'])]
    public function indexb(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidature/indexback.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }
    #[Route('/new/{idRecurt}', name: 'app_candidature_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,Security $security, $idRecurt): Response
    {        //$idRecurt = $request->get('idRecurt');
        $candidature = new Candidature();
        $user = $security->getUser();
        $candidature->setUser($user);
        $annoncerecrutement = $entityManager->getRepository(Annoncerecrutement::class)->find($idRecurt);
        $candidature ->setIdannrecru($annoncerecrutement);
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);
        $currentDate = new \DateTime();
        $candidature->setDatecandidature($currentDate);
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $file = $form->get('certifforma')->getData();
            
            if ($file instanceof UploadedFile) {
                $fileName = uniqid().'.'.$file->guessExtension();

                // Move the file to the desired directory
                $file->move(
                    'img/',
                    $fileName
                );

                // Save the image file name to the entity
                $candidature->setCertifforma($fileName);
            }

            $entityManager->persist($candidature);
            $entityManager->flush();

            return $this->redirectToRoute('app_annoncerecrutement_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            //$candidature -> setIdannrecru($annoncerecrutement);

            $entityManager->persist($candidature);
            $entityManager->flush();

            return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('candidature/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }

    #[Route('/{idcandidature}', name: 'app_candidature_show', methods: ['GET'])]
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    #[Route('/{idcandidature}/edit', name: 'app_candidature_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidature $candidature, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidature/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }


    #[Route('/{idcandidature}', name: 'app_candidature_delete', methods: ['POST'])]
    public function delete(Request $request, Candidature $candidature, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidature->getIdcandidature(), $request->request->get('_token'))) {
            $entityManager->remove($candidature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
    }


#[Route('/candidature/{id}/{decision}', name: 'confirm_candidature', methods: ['GET'])]

public function handleCandidatureDecision(int $id, string $decision, EntityManagerInterface $entityManager): RedirectResponse
// {
//     // Check if the user is an admin (you can implement your own logic to check admin access)

//     $candidature = $entityManager->getRepository(Candidature::class)->find($id);

//     if (!$candidature) {
//         throw $this->createNotFoundException('Candidature not found');
//     }

//     // Update the candidacy's "accepte" field based on the admin's decision
//     if ($decision === 'accept') {
//         $candidature->setStatusCandidature(true);

//         // Archive the candidature when accepted
//         $candidature->setArchived(true);
//     } elseif ($decision === 'refuse') {
//         $candidature->setStatusCandidature(false);
//     }

//     $entityManager->flush();

//     $this->addFlash('success', 'Candidature decision has been saved.');

//     // Redirect the admin back to the page that displays the candidates for the specific concours
//     return $this->redirectToRoute('app_candidature_index');
// }

// #[Route('/confirm_candidature/{id}', name: 'confirm_candidature', methods: ['GET', 'POST'])]
// public function confirmCandidature($id, Request $request, ?string $decision, EntityManagerInterface $entityManager): Response
{
    $candidature = $entityManager->getRepository(Candidature::class)->find($id);

    if (!$candidature) {
        return new Response($this->json(['error' => 'Confirmation not found']), Response::HTTP_NOT_FOUND);
    }

    if ($decision === 'accept') {
        if (!$candidature->isArchived() && !$candidature->isStatuscandidature()) {
            $candidature->setStatuscandidature(true);
            $candidature->setArchived(true);

            $annoncerecrutement = $candidature->getIdannrecru();

            // Reduce the number of available positions
            $newAvailableSeats = max(0, $annoncerecrutement->getNbPosteRecherche() - 1);
            $annoncerecrutement->setNbPosteRecherche($newAvailableSeats);

            $entityManager->persist($annoncerecrutement);
            $entityManager->persist($candidature);
            $entityManager->flush();
        }
    } elseif ($decision === 'refuse') {
        $candidature->setStatuscandidature(false);
        $candidature->setArchived(true);
        $entityManager->persist($candidature);
        $entityManager->flush();
    } else {
        // Handle invalid decision, throw an exception, or return an appropriate response.
        throw new \InvalidArgumentException('Invalid decision');
    }

    return $this->redirectToRoute('app_candidature_index');
}
// #[Route('/confirm_candidature/{id}', name: 'confirm_candidature', methods: ['GET', 'POST'])]
// public function confirmCandidature($id, Request $request, ?string $decision, EntityManagerInterface $entityManager, AnnoncerecrutementRepository $annoncerecrutementRepository): Response
// {
//     $candidature = $entityManager->getRepository(Candidature::class)->find($id);

//     if (!$candidature) {
//         throw $this->createNotFoundException('Confirmation not found');
//     }

//     $annoncerecrutement = $candidature->getIdannrecru();

//     if ($decision === 'accept') {
//         $candidature->setStatusCandidature(true);

//         // Reduce the number of available seats
//         $newAvailableSeats = $annoncerecrutement->getNbPosteRecherche() - 1;

//         if ($newAvailableSeats <= 0) {
//             // If no more available seats, archive the announcement
//             $annoncerecrutement->setArchived(true);
//         }

//         $annoncerecrutement->setNbPosteRecherche($newAvailableSeats);
//     } elseif ($decision === 'refuse') {
//         $candidature->setStatusCandidature(false);
//     }

//     $entityManager->persist($annoncerecrutement);
//     $entityManager->persist($candidature);
//     $entityManager->flush();

//     return $this->redirectToRoute('app_candidature_index');
// }




}
