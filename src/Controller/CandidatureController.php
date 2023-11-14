<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidature')]
class CandidatureController extends AbstractController
{
    #[Route('/', name: 'app_candidature_index', methods: ['GET'])]
    public function index(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_candidature_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidature = new Candidature();
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

   /**
 * @Route("/candidature/{id}/{decision}", name="app_candidature_decision", methods={"GET"})
 */
public function handleCandidatureDecision(int $id, string $decision, EntityManagerInterface $entityManager): RedirectResponse
{
    // Check if the user is an admin (you can implement your own logic to check admin access)

    $candidature = $entityManager->getRepository(Candidature::class)->find($id);
    //var_dump($candidature);
    //die;
    if (!$candidature) {
        throw $this->createNotFoundException('Candidature not found');
    }

    // Update the candidacy's "accepte" field based on the admin's decision
    if ($decision === 'accept') {
        $candidature->setStatusCandidature(true);
        
    } elseif ($decision === 'refuse') {
        $candidature->setStatusCandidature(false);
    }

    $entityManager->flush();

    $this->addFlash('success', 'Candidature decision has been saved.');

    // Redirect the admin back to the page that displays the candidates for the specific concours
    // You might want to replace 'your_route_name' with the actual route name you want to redirect to
    return $this->redirectToRoute('app_candidature_index');
}

}
