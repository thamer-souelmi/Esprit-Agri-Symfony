<?php

namespace App\Controller;

use App\Entity\Annonceinvestissement;
use App\Entity\Negociation;
use App\Form\NegociationType;
use App\Repository\NegociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/negociation')]
class NegociationController extends AbstractController
{
        #[Route('/', name: 'app_negociation_index', methods: ['GET'])]
        public function index(NegociationRepository $negociationRepository, PaginatorInterface $paginator, Request $request): Response
{
    // Fetch only non-archived negotiations with etatnego 1 (accepted)
    $acceptedNegociations = $negociationRepository->findBy(['isArchived' => 1, 'etatnego' => 1]);

    // Fetch only non-archived negotiations with etatnego 0 (en cours)
    $enCoursNegociations = $negociationRepository->findBy(['isArchived' => NULL, 'etatnego' => NULL]);

    // Combine the two sets of negotiations
    $allNegociations = array_merge($acceptedNegociations, $enCoursNegociations);

    // Paginate the results
    $pagination = $paginator->paginate(
        $allNegociations,
        $request->query->getInt('page', 1),
        6 // Number of items per page
    );

    // Iterate over the items in the pagination and add the contentHidden variable
    foreach ($pagination as $negociation) {
        $negociation->contentHidden = $this->badWords($negociation->getMessage());
    }

    return $this->render('negociation/index.html.twig', [
        'pagination' => $pagination,
    ]);
}
     /////////////////////////////BACK//////////////////////////////////////////
     #[Route('/backnego', name: 'app_negociation_index_back', methods: ['GET'])]
     public function indexNego(NegociationRepository $negociationRepository, PaginatorInterface $paginator, Request $request): Response
     {
         // Separate negotiations into accepted and rejected based on etatnego
         $acceptedNegociations = $negociationRepository->findBy(['etatnego' => 1]);
         $rejectedNegociations = $negociationRepository->findBy(['etatnego' => 0]);
     
         // Paginate both sets of negotiations
         $acceptedPagination = $paginator->paginate(
             $acceptedNegociations,
             $request->query->getInt('page_accepted', 1), // Change 'page_accepted' to your preference
             4 // Number of items per page
         );
     
         $rejectedPagination = $paginator->paginate(
             $rejectedNegociations,
             $request->query->getInt('page_rejected', 1), // Change 'page_rejected' to your preference
             4 // Number of items per page
         );
     
         return $this->render('BACKnego/index.html.twig', [
             'acceptedPagination' => $acceptedPagination,
             'rejectedPagination' => $rejectedPagination,
         ]);
     }
    // #[Route('/backnego', name: 'app_negociation_index_back', methods: ['GET'])]
    // public function indexNego(NegociationRepository $negociationRepository): Response
    // {
    //     return $this->render('BACKnego/index.html.twig', [
    //         'negociations' => $negociationRepository->findAll(),
    //     ]);
    // }
      /////////////////////////////BACK//////////////////////////////////////////

      #[Route('/new/{idannonce}', name: 'app_negociation_new', methods: ['GET', 'POST'])]
      public function new(Request $request, EntityManagerInterface $entityManager, $idannonce,MailerInterface $mailer,Security $security): Response
      {
          $annonceinvestissement = $entityManager->getRepository(Annonceinvestissement::class)->find($idannonce);
          $negociation = new Negociation();
          $user = $security->getUser();
          $negociation->setUsers($user);
          $negociation->setIdannonce($annonceinvestissement);
          $currentDate = new \DateTime();
          $negociation->setDatenegociation($currentDate);
          $form = $this->createForm(NegociationType::class, $negociation);
          $form->handleRequest($request);
      
          if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
            ->from('espritagri11@gmail.com')
            ->to('montaha.metjaouel1@gmail.com')
            ->subject('Négociation Investissement')
            ->htmlTemplate('negociation/mail.html.twig')
            ->context([
                'negociation'=>$negociation,
                // Other context data...
            ]);;
            
                $mailer->send($email);
                // Envoyé avec succès, vous pouvez renvoyer une réponse de succès
                $entityManager->persist($negociation);
              
              $entityManager->flush();
      
              // Add flash message after successful flush
              $this->addFlash(
                  'success',
                  'Négociation ajoutée avec succès'
              );
               
              
      
              return $this->redirectToRoute('app_annonceinvestissement_index', [], Response::HTTP_SEE_OTHER);
          }
          
      
          return $this->renderForm('negociation/new.html.twig', [
              'negociation' => $negociation,
              'form' => $form,
          ]);
          
         
      }
      
     /////////////////////////////BACK//////////////////////////////////////////
     #[Route('/newNegoBack', name: 'app_negociation_new_back', methods: ['GET', 'POST'])]
    public function newBack(Request $request, EntityManagerInterface $entityManager): Response
    {
        $negociation = new Negociation();
        $currentDate = new \DateTime();
        $negociation->setDatenegociation($currentDate);
        $form = $this->createForm(NegociationType::class, $negociation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($negociation);
            $entityManager->flush();

            return $this->redirectToRoute('app_negociation_index_back', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('BACKnego/new.html.twig', [
            'negociation' => $negociation,
            'form' => $form,
        ]);
    }
      /////////////////////////////BACK//////////////////////////////////////////


//    #[Route('/{idannonce}', name: 'app_negociation_show', methods: ['GET'])]
//     /*public function show(Negociation $negociation): Response
//     {
//         return $this->render('negociation/show.html.twig', [
//             'negociation' => $negociation,
//         ]);
//     }*/
//    public function afficherNegociations(int $idannonce, PaginatorInterface $paginator, Request $request): Response
// {
//     // Fetch the necessary data based on the $idannonce   findBy(array('etatnego' => 1))
//     $negociations = $this->getDoctrine()->getRepository(Negociation::class)->findBy(['idannonce' => $idannonce]);

//     // Paginate the results
//     $pagination = $paginator->paginate(
//         $negociations,
//         $request->query->getInt('page', 1),
//         3 // Number of items per page
//     );

//     // You can do additional processing or fetch more data if needed

//     return $this->render('negociation/show.html.twig', [
//         'pagination' => $pagination,
//     ]);
// }
#[Route('/{idannonce}', name: 'app_negociation_show', methods: ['GET'])]
public function afficherNegociations(int $idannonce, PaginatorInterface $paginator, Request $request): Response
{
    // Fetch only non-archived negotiations based on the $idannonce
    $negociations = $this->getDoctrine()->getRepository(Negociation::class)->findBy(['idannonce' => $idannonce, 'isArchived' => NULL]);

    // Iterate over the negotiations and add the contentHidden variable
    foreach ($negociations as $negociation) {
        $negociation->contentHidden = $this->badWords($negociation->getMessage());
    }

    // Paginate the results
    $pagination = $paginator->paginate(
        $negociations,
        $request->query->getInt('page', 1),
        3 // Number of items per page
    );

    // You can do additional processing or fetch more data if needed

    return $this->render('negociation/show.html.twig', [
        'pagination' => $pagination,
    ]);
}
/////////////////////////////BACK//////////////////////////////////////////
#[Route('/{id}/backnego', name: 'app_negociation_show_back', methods: ['GET'])]
public function showBAck(Negociation $negociation): Response
{
    return $this->render('BACKnego/show.html.twig', [
        'negociation' => $negociation,
    ]);
}
    /////////////////////////////BACK//////////////////////////////////////////

    #[Route('/{id}/edit', name: 'app_negociation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Negociation $negociation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NegociationType::class, $negociation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_negociation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('negociation/edit.html.twig', [
            'negociation' => $negociation,
            'form' => $form,
        ]);
    }

    /////////////////////////////BACK//////////////////////////////////////////
    #[Route('/{id}/editbacknego', name: 'app_negociation_edit_back', methods: ['GET', 'POST'])]
    public function editBAck(Request $request, Negociation $negociation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NegociationType::class, $negociation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_negociation_index_back', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('BACKnego/edit.html.twig', [
            'negociation' => $negociation,
            'form' => $form,
        ]);
    }

    /////////////////////////////BACK//////////////////////////////////////////

    #[Route('/{id}', name: 'app_negociation_delete', methods: ['POST'])]
    public function delete(Request $request, Negociation $negociation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$negociation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($negociation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_negociation_index', [], Response::HTTP_SEE_OTHER);
    }
// #[Route('/decision/{id}/{decision}', name: 'app_negociation_decision', methods: ['GET'])]  
// public function handleNegociationDecision(int $id, string $decision, EntityManagerInterface $entityManager): RedirectResponse
// {
//     // Check if the user is an admin (you can implement your own logic to check admin access)

//     $negociation = $entityManager->getRepository(Negociation::class)->find($id);
//     //var_dump($negociation);
//     //die;
//     if (!$negociation) {
//         throw $this->createNotFoundException('Negociation not found');
//     }

//     // Update the candidacy's "accepte" field based on the admin's decision
//     if ($decision === 'accept') {
//         $negociation->setEtatnego(true);
        
//     } elseif ($decision === 'refuse') {
//         $negociation->setEtatnego(false);
//     }

//     $entityManager->flush();

//     $this->addFlash('success', 'La décision de votre négociation a été enregistrée.');

//     // Redirect the admin back to the page that displays the candidates for the specific concours
//     // You might want to replace 'your_route_name' with the actual route name you want to redirect to
//     return $this->redirectToRoute('app_negociation_index');
// }
////////////////////////////////////




#[Route('/stats', name: 'app_negociation_stats', methods: ['GET'])]
public function statistics(Request $request, NegociationRepository $negoRepo, PaginatorInterface $paginator): Response
{
    // Fetch data for statistics
    $etat0Count = $negoRepo->countByEtat(0);
    $etat1Count = $negoRepo->countByEtat(1);

    // Fetch data for pagination
    $pagination = $paginator->paginate(
        $negoRepo->findAll(), // Assuming you want to paginate all negotiations
        $request->query->getInt('page', 1),
        10 // Items per page
    );

    return $this->render('BACKnego/stats.html.twig', [
        'etat0Count' => $etat0Count,
        'etat1Count' => $etat1Count,
        'pagination' => $pagination,
        // Add more data as needed
    ]);
}
    #[Route('/decision/{id}/{decision}', name: 'app_negociation_decision', methods: ['GET'])]
    public function NegociationArchived(int $id, string $decision, EntityManagerInterface $entityManager): RedirectResponse
{
    $negociation = $entityManager->getRepository(Negociation::class)->find($id);

    if (!$negociation) {
        throw $this->createNotFoundException('Negociation not found');
    }

    if ($decision === 'accept') {
        if (!$negociation->isIsArchived()) {
            $negociation->setEtatnego(true);
            $negociation->setIsArchived(true); // Archive the negotiation
            $annonceinvestissement = $negociation->getIdannonce();

            $entityManager->persist($annonceinvestissement);
            $entityManager->persist($negociation);
            $entityManager->flush();
        }
    } elseif ($decision === 'refuse') {
        $negociation->setEtatnego(false);
        $negociation->setIsArchived(true); // Archive the negotiation
        $entityManager->persist($negociation);
        $entityManager->flush();
    } else {
        // Handle invalid decision, throw an exception, or return an appropriate response.
        throw new \InvalidArgumentException('Invalid decision');
    }

    $this->addFlash('success', 'La décision de votre négociation a été enregistrée.');

    // Redirect the admin back to the page that displays the negotiations
    return $this->redirectToRoute('app_negociation_index');
}
private function badWords(string $text): bool
    {
        $badWords = ['violence', 'haine', 'israil','putain','débile','gueule','merde','fils de','espece de','idiot']; // Remplacez ces valeurs par votre liste de mots interdits

        foreach ($badWords as $badWord) {
            if (stripos($text, $badWord) !== false) {
                return true;
            }
        }
        
        return false;
    }  
}
