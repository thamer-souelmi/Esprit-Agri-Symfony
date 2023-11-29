<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Service\TwilioService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;



#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager,ReclamationRepository $reclamationRepository, Security $security,PaginatorInterface $paginator,Request $request): Response
    {
        $user = $security->getUser();
        
            $id = $user->getId(); // Assuming getId() returns the user's ID
            $reclamations = $entityManager
                ->getRepository(Reclamation::class)
                ->findByUserId($id);
            $pagination = $paginator->paginate(
                    $reclamations, // Users query
                    $request->query->getInt('page', 1), // Current page
                    5// Items per page
                );
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
            'pagination' => $pagination,
        ]);
    }
    #[Route('/back/{id}', name: 'app_reclamation_indexb', methods: ['GET'])]
    public function indexb($id,EntityManagerInterface $entityManager,ReclamationRepository $reclamationRepository, Security $security): Response
    {
        
            $reclamations = $entityManager
                ->getRepository(Reclamation::class)
                ->reclamation($id);
        return $this->render('reclamation/indexb.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }
    #[Route('/new/{productId}', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new($productId, Request $request, EntityManagerInterface $entityManager, Security $security, TwilioService $twilioService, MailerInterface $mailer): Response
    {
        $reclamation = new Reclamation();
        $produit = $entityManager->getRepository(Produit::class)->find($productId);
        $user = $security->getUser();
        $reclamation->setUser($user);
        $reclamation->setProduit($produit);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        $errorMessage = null;
    
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->badWords($reclamation->getDescription())) {
                // Mots inappropriés détectés, définir le message d'erreur
                $errorMessage = 'Votre réclamation contient des termes inappropriés.';
            } else {
            $produit = $reclamation->getProduit();
            // $to = '+21650378582'; // Static phone number
    
            // $message = 'New category created: '; // Modify the message as needed
            // $twilioService->sendSMS($to, $message);
    
            // #[Route('/mail', name: 'mail')]
            $email = (new TemplatedEmail())
                ->from(new Address('espritagri11@gmail.com', 'Esprit Agri'))
                ->to($user->getMail())
                ->subject('Reclamation')
                ->htmlTemplate('reclamation/confirmation_email.html.twig')
                ->context([
                    'user' => $user,
                    'produit'=>$produit,
                    // Other context data...
                ]);
    
            try {
                $mailer->send($email);
    
                // Persist the entity
                $entityManager->persist($reclamation);
                $entityManager->flush();
    
                // Redirect after successful email sending and entity persistence
                return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                // Handle email sending failure
                return new Response('Error sending email: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        }
    
        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
            'errorMessage'=>$errorMessage
        ]);
    }
    

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    private function badWords(string $text): bool
    {
        $badWords = ['pidev', 'projet', 'israil']; // Remplacez ces valeurs par votre liste de mots interdits

        foreach ($badWords as $badWord) {
            if (stripos($text, $badWord) !== false) {
                return true;
            }
        }
        
        return false;
    }  
}
