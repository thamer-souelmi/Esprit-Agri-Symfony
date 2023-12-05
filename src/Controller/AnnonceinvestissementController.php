<?php

namespace App\Controller;

use App\Entity\Annonceinvestissement;
use App\Form\AnnonceinvestissementType;
use App\Repository\AnnonceinvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Endroid\QrCode\QrCode; 
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

#[Route('/annonceinvestissement')]
class AnnonceinvestissementController extends AbstractController
{
#[Route('/', name: 'app_annonceinvestissement_index', methods: ['GET'])]
public function index(AnnonceinvestissementRepository $annonceinvestissementRepository, PaginatorInterface $paginator, Request $request,TranslatorInterface $translator): Response
{
    $annonceinvestissements = $annonceinvestissementRepository->findAll();

    $pagination = $paginator->paginate(
        $annonceinvestissements,
        $request->query->getInt('page', 1),
        4 // Number of items per page
    );
    // Example of using $translator to translate a message
    $translatedMessage = $translator->trans('hello world.');

    return $this->render('annonceinvestissement/index.html.twig', [
        'pagination' => $pagination,
        'translatedMessage' => $translatedMessage, // Pass the translated message to your Twig template
    ]);
}
    /////////////////////////////BACK//////////////////////////////////////////
    #[Route('/back', name: 'app_annonceinvestissement_index_back', methods: ['GET'])]
    public function indexBack(AnnonceinvestissementRepository $annonceinvestissementRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $annonceinvestissements = $annonceinvestissementRepository->findAll();
    
        $pagination = $paginator->paginate(
            $annonceinvestissements,
            $request->query->getInt('page', 1),
            4 // Number of items per page
        );
    
        return $this->render('BACKannonceinv/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    /////////////////////////////BACK//////////////////////////////////////////

    #[Route('/new', name: 'app_annonceinvestissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Security $security): Response
    {
        $user = $security->getUser();
        $annonceinvestissement = new Annonceinvestissement();
        $annonceinvestissement->setUser($user);
        $currentDate = new \DateTime();
        $annonceinvestissement->setDatepublication($currentDate);
        $form = $this->createForm(AnnonceinvestissementType::class, $annonceinvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $file = $form->get('photo')->getData();
            
            if ($file instanceof UploadedFile) {
                $fileName = uniqid().'.'.$file->guessExtension();

                // Move the file to the desired directory
                $file->move(
                    'E:/Esprit-Agri-Symfony/public/img/',
                    $fileName
                );

                // Save the image file name to the entity
                $annonceinvestissement->setPhoto($fileName);
            }
            $annonceinvestissement -> setUser($user);

            $entityManager->persist($annonceinvestissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonceinvestissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonceinvestissement/new.html.twig', [
            'annonceinvestissement' => $annonceinvestissement,
            'form' => $form,
        ]);
    }
    /////////////////////////////BACK//////////////////////////////////////////
    #[Route('/newBack', name: 'app_annonceinvestissement_new_back', methods: ['GET', 'POST'])]
    public function newBack(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonceinvestissement = new Annonceinvestissement();
        $form = $this->createForm(AnnonceinvestissementType::class, $annonceinvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $file = $form->get('photo')->getData();
            
            if ($file instanceof UploadedFile) {
                $fileName = uniqid().'.'.$file->guessExtension();

                // Move the file to the desired directory
                $file->move(
                    'E:/Esprit-Agri-Symfony/public/img/',
                    $fileName
                );

                // Save the image file name to the entity
                $annonceinvestissement->setPhoto($fileName);
            }

            $entityManager->persist($annonceinvestissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonceinvestissement_index_back', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('BACKannonceinv/new.html.twig', [
            'annonceinvestissement' => $annonceinvestissement,
            'form' => $form,
        ]);
    }
    /////////////////////////////BACK//////////////////////////////////////////

    #[Route('/{idannonce}', name: 'app_annonceinvestissement_show', methods: ['GET'])]
    public function show(Annonceinvestissement $annonceinvestissement): Response
    {
        return $this->render('annonceinvestissement/show.html.twig', [
            'annonceinvestissement' => $annonceinvestissement,
        ]);
    }
    /////////////////////////////BACK//////////////////////////////////////////
    #[Route('/{idannonce}/backinv', name: 'app_annonceinvestissement_show_back', methods: ['GET'])]
    public function showBack(Annonceinvestissement $annonceinvestissement): Response
    {
        return $this->render('BACKannonceinv/show.html.twig', [
            'annonceinvestissement' => $annonceinvestissement,
        ]);
    }
    /////////////////////////////BACK//////////////////////////////////////////
    
    

    #[Route('/{idannonce}/edit', name: 'app_annonceinvestissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonceinvestissement $annonceinvestissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnonceinvestissementType::class, $annonceinvestissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annonceinvestissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonceinvestissement/edit.html.twig', [
            'annonceinvestissement' => $annonceinvestissement,
            'form' => $form,
        ]);
    }
     /////////////////////////////BACK//////////////////////////////////////////
     #[Route('/{idannonce}/edit/backInv', name: 'app_annonceinvestissement_edit_back', methods: ['GET', 'POST'])]
     public function editBack(Request $request, Annonceinvestissement $annonceinvestissement, EntityManagerInterface $entityManager): Response
     {
         $form = $this->createForm(AnnonceinvestissementType::class, $annonceinvestissement);
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $entityManager->flush();
 
             return $this->redirectToRoute('app_annonceinvestissement_index_back', [], Response::HTTP_SEE_OTHER);
         }
 
         return $this->renderForm('BACKannonceinv/edit.html.twig', [
             'annonceinvestissement' => $annonceinvestissement,
             'form' => $form,
         ]);
     }
      /////////////////////////////BACK//////////////////////////////////////////
      #[Route('/delete/{idannonce}', name: 'app_annonceinvestissement_delete', methods: ['POST'])]
public function delete(
    Request $request,
    Annonceinvestissement $annonceinvestissement,
    AnnonceinvestissementRepository $annonceinvestissementRepository,
    EntityManagerInterface $entityManager
): Response {
    // Ajouter la vérification si l'annonce est utilisée par une négociation
    if ($annonceinvestissementRepository->isAnnonceInUse($annonceinvestissement)) {
        $this->addFlash('danger', 'Cette annonce contient une ou plusieurs négociations. Suppression impossible.');
    } else {
        if ($this->isCsrfTokenValid('delete' . $annonceinvestissement->getIdannonce(), $request->request->get('_token'))) {
            // Use the entity manager to remove the entity
            $entityManager->remove($annonceinvestissement);
            $entityManager->flush();

            $this->addFlash('success', 'Annonce a été supprimée avec succès.');
        } else {
            $this->addFlash('danger', 'Le jeton CSRF n\'est pas valide. Suppression impossible.');
        }
    }

    return $this->redirectToRoute('app_annonceinvestissement_index', [], Response::HTTP_SEE_OTHER);
}

    /////////////////////////////BACK//////////////////////////////////////////
    #[Route('/{idannonce}/backinvsupp', name: 'app_annonceinvestissement_delete_back', methods: ['POST'])]
    public function deleteBack(Request $request, Annonceinvestissement $annonceinvestissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonceinvestissement->getIdannonce(), $request->request->get('_token'))) {
            $entityManager->remove($annonceinvestissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annonceinvestissement_index_back', [], Response::HTTP_SEE_OTHER);
    }
    /////////////////////////////BACK//////////////////////////////////////////


    //******************************************QR CODE**************************************************//
    #[Route('/{idannonce}/qrcode', name: 'app_annonceinvestissement_qrcode', methods: ['GET'])]
    public function generateQrCode(Annonceinvestissement $annonceinvestissement,$id,AnnonceinvestissementRepository $repo)
    {
        $annonceinvestissement = $repo->find($id);
        // Créer un nouvel objet QRCode
        $qrContent = sprintf(
            "Titre de l'annonce: %s\nMontant: %s\nLocalisation:\nDate de publication: %s",
            $annonceinvestissement->getTitre(),
            $annonceinvestissement->getMontant(),
            $annonceinvestissement->getLocalisation(),
            $annonceinvestissement->getDatepublication()

        );

        // Créer une instance de QrCode
        $qrCode = new QrCode($qrContent);

        // Modifier les options du QRCode
        $qrCode->setSize(250); // Définir la taille du QRCode en pixels

        // Générer l'image du QRCode
        $qrCodeImage = $qrCode->writeString();
        

        // Créer une réponse HTTP avec l'image du QRCode
        $response = new Response($qrCodeImage, Response::HTTP_OK, [
            'Content-Type' => 'image/png',
        ]);

        return $response;
    }
    
    
}
