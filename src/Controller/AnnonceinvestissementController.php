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

#[Route('/annonceinvestissement')]
class AnnonceinvestissementController extends AbstractController
{
    #[Route('/', name: 'app_annonceinvestissement_index', methods: ['GET'])]
    public function index(AnnonceinvestissementRepository $annonceinvestissementRepository): Response
    {
        return $this->render('annonceinvestissement/index.html.twig', [
            'annonceinvestissements' => $annonceinvestissementRepository->findAll(),
        ]);
    }
    /////////////////////////////BACK//////////////////////////////////////////
    #[Route('/back', name: 'app_annonceinvestissement_index_back', methods: ['GET'])]
    public function indexBack(AnnonceinvestissementRepository $annonceinvestissementRepository): Response
    {
        return $this->render('BACKannonceinv/index.html.twig', [
            'annonceinvestissements' => $annonceinvestissementRepository->findAll(),
        ]);
    }
    /////////////////////////////BACK//////////////////////////////////////////

    #[Route('/new', name: 'app_annonceinvestissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonceinvestissement = new Annonceinvestissement();
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

    #[Route('/{idannonce}', name: 'app_annonceinvestissement_delete', methods: ['POST'])]
    public function delete(Request $request, Annonceinvestissement $annonceinvestissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonceinvestissement->getIdannonce(), $request->request->get('_token'))) {
            $entityManager->remove($annonceinvestissement);
            $entityManager->flush();
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
    
}
