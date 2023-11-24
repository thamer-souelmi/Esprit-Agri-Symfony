<?php
namespace App\Controller;

use App\Entity\Note;
use App\Entity\Veterinaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RatingController extends AbstractController
{
    
    #[Route('/rate/{veterinaireId}/{note}', name: 'rate_veterinaire')]
    public function rateVeterinaire($veterinaireId, $note)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        // Récupérer le vétérinaire
        $veterinaire = $entityManager->getRepository(Veterinaire::class)->find($veterinaireId);

        if (!$veterinaire) {
            return new JsonResponse(['success' => false, 'error' => 'Vétérinaire non trouvé']);
        }

        // Créer une nouvelle note
        $nouvelleNote = new Note();
        $nouvelleNote->setValeur($note);
        $nouvelleNote->setVeterinaire($veterinaire);

        // Persist et flush les changements
        $entityManager->persist($nouvelleNote);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }
}