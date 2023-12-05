<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/note')]
class NoteController extends AbstractController
{
    #[Route('/', name: 'app_note_index', methods: ['GET'])]
    public function index(NoteRepository $noteRepository): Response
    {
        return $this->render('note/index.html.twig', [
            'notes' => $noteRepository->findAll(),
        ]);
    }

    

    #[Route('/{id}', name: 'app_note_show', methods: ['GET'])]
    public function show(Note $note): Response
    {
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }
    // NoteController.php

// ...

#[Route('/new', name: 'app_note_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $note = new Note();
    $form = $this->createForm(NoteType::class, $note);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Associer la note à l'utilisateur actuel
        $currentUser = $this->getUser();
        $note->setUser($currentUser);

        $entityManager->persist($note);
        $entityManager->flush();

        return $this->redirectToRoute('app_note_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('note/new.html.twig', [
        'note' => $note,
        'form' => $form,
    ]);
}

#[Route('/{id}/edit', name: 'app_note_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Note $note, EntityManagerInterface $entityManager): Response
{
    // Vérifier si l'utilisateur actuel est autorisé à éditer cette note
    $this->denyAccessUnlessGranted('EDIT', $note);

    $form = $this->createForm(NoteType::class, $note);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_note_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('note/edit.html.twig', [
        'note' => $note,
        'form' => $form,
    ]);
}

#[Route('/{id}', name: 'app_note_delete', methods: ['POST'])]
public function delete(Request $request, Note $note, EntityManagerInterface $entityManager): Response
{
    // Vérifier si l'utilisateur actuel est autorisé à supprimer cette note
    $this->denyAccessUnlessGranted('DELETE', $note);

    if ($this->isCsrfTokenValid('delete'.$note->getId(), $request->request->get('_token'))) {
        $entityManager->remove($note);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_note_index', [], Response::HTTP_SEE_OTHER);
}

// ...

#[Route('/rate/{veterinaireId}/{note}', name: 'rate_veterinaire')]
public function rateVeterinaire($veterinaireId, $note)
{
    $entityManager = $this->getDoctrine()->getManager();

    // Récupérer l'utilisateur actuel (peut être récupéré à partir du système de sécurité)
    $user = $this->getUser();

    // Récupérer le vétérinaire
    $veterinaire = $entityManager->getRepository(Veterinaire::class)->find($veterinaireId);

    if (!$veterinaire) {
        return new JsonResponse(['success' => false, 'error' => 'Vétérinaire non trouvé']);
    }

    // Vérifier si l'utilisateur a déjà noté ce vétérinaire
    $existingNote = $entityManager->getRepository(Note::class)->findOneBy(['user' => $user, 'veterinaire' => $veterinaire]);

    if ($existingNote) {
        // Mettre à jour la note existante
        $existingNote->setValeur($note);
    } else {
        // Créer une nouvelle note
        $nouvelleNote = new Note();
        $nouvelleNote->setValeur($note);
        $nouvelleNote->setVeterinaire($veterinaire);
        $nouvelleNote->setUser($user);

        // Persist et flush les changements
        $entityManager->persist($nouvelleNote);
    }

    // Flush les changements
    $entityManager->flush();

    // Recalculer la moyenne
    $averageRating = $veterinaire->getAverageRating(); // Assurez-vous que cela est correctement implémenté

    return new JsonResponse(['success' => true, 'averageRating' => $averageRating]);
}

}

