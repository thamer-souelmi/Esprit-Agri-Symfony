<?php

namespace App\Controller;

use App\Entity\Annoncerecrutement;
use App\Entity\Candidature;
use App\Entity\Ouvrier;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use App\Repository\AnnoncerecrutementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\TwilioService;
use Symfony\Component\Mime\Address;

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
    public function new(Request $request, EntityManagerInterface $entityManager ,Security $security, $idRecurt, MailerInterface $mailer): Response
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
            $email = (new TemplatedEmail())
            ->from(new Address('espritagri11@gmail.com', 'Esprit '))
            ->to('haifa.bensalah@esprit.tn')
            ->subject('Candidature')
            ->htmlTemplate('annoncerecrutement/confirmation_email.html.twig')
            ->context([
                'candidature' => $candidature,
                // Other context data...
            ]);
    
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
            $mailer->send($email);

            $entityManager->persist($candidature);
            $entityManager->flush();

            return $this->redirectToRoute('app_annoncerecrutement_index', [], Response::HTTP_SEE_OTHER);
        }

       
        return $this->renderForm('candidature/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }

    // #[Route('/{idcandidature}', name: 'app_candidature_show', methods: ['GET'])]
    // public function show(Candidature $candidature): Response
    // {
    //     return $this->render('candidature/show.html.twig', [
    //         'candidature' => $candidature,
    //     ]);
    // }
//     #[Route('/{idRecrut}', name: 'app_candidature_show', methods: ['GET'])]
//     public function show(Candidature $candidature, PaginatorInterface $paginator, Request $request): Response
// {
//     // Fetch the necessary data based on the $candidature
//     $relatedData = $this->getDoctrine()->getRepository(Candidature::class)->findBy(['idRecurt' => $candidature->getIdannrecru()]);

//     // Paginate the results
//     $pagination = $paginator->paginate(
//         $relatedData,
//         $request->query->getInt('page', 1),
//         3 // Number of items per page
//     );

//     // You can do additional processing or fetch more data if needed

//     return $this->render('candidature/show.html.twig', [
//         'candidature' => $candidature,
//         'pagination' => $pagination,
//     ]);
// }
#[Route('/{idRecrut}', name: 'app_show_related_candidatures', methods: ['GET'])]
public function showRelatedCandidatures(int $idRecrut, CandidatureRepository $candidatureRepository, PaginatorInterface $paginator, Request $request): Response
{
    // Fetch the necessary data based on the $idRecrut
    $annoncerecrutement = $this->getDoctrine()->getRepository(Annoncerecrutement::class)->find($idRecrut);

    if (!$annoncerecrutement) {
        throw $this->createNotFoundException('Annonce Recrutement not found');
    }

    // Fetch related candidatures for the given annonce recrutement
    $relatedCandidatures = $candidatureRepository->findBy(['idannrecru' => $annoncerecrutement]);

    // Paginate the results
    $pagination = $paginator->paginate(
        $relatedCandidatures,
        $request->query->getInt('page', 1),
        3 // Number of items per page
    );

    // You can do additional processing or fetch more data if needed

    return $this->render('candidature/show.html.twig', [
        'pagination' => $pagination,
        'annonceRecrutement' => $annoncerecrutement,
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

public function handleCandidatureDecision(SessionInterface $session,int $id, string $decision, EntityManagerInterface $entityManager, TwilioService $twilioService): RedirectResponse

{
    $candidature = $entityManager->getRepository(Candidature::class)->find($id);

    if (!$candidature) {
        return new Response($this->json(['error' => 'Confirmation not found']), Response::HTTP_NOT_FOUND);
    }
if($candidature->getIdannrecru()->getNbPosteRecherche()!=0){
    if ($decision === 'accept') {
        if (!$candidature->isArchived() && !$candidature->isStatuscandidature()) {
            $twilioService ->sendSMS("+21628181314"," felicitation vous ete accepter  ");
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
        $twilioService ->sendSMS("+21628181314"," Je suis désolé, mais votre demande a été rejetée.  ");

    } else {
        // Handle invalid decision, throw an exception, or return an appropriate response.
        throw new \InvalidArgumentException('Invalid decision');
    }
}else {
    $this->addFlash('danger', 'vous avez ateint le nombre maximum de l\'acceptation de cette annonces ');
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
