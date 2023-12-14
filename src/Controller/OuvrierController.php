<?php

namespace App\Controller;

use App\Entity\Ouvrier;
use App\Form\OuvrierType;
use App\Repository\OuvrierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;


#[Route('/ouvrier')]
class OuvrierController extends AbstractController
{
    #[Route('/', name: 'app_ouvrier_index', methods: ['GET'])]
    public function index(OuvrierRepository $ouvrierRepository): Response
    {
        return $this->render('ouvrier/index.html.twig', [
            'ouvriers' => $ouvrierRepository->findAll(),
        ]);
    }
    #[Route('/back', name: 'app_equipeback_index', methods: ['GET'])]
    public function indexba(OuvrierRepository $ouvrierRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Pass the array of annoncerecrutements to the paginator
        $pagination = $paginator->paginate(
            $ouvrierRepository->findAll(), // Pass the array of annoncerecrutements
            $request->query->getInt('page', 1), // Current page
            5 // Items per page
        );
    
        return $this->render('ouvrier/back.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_ouvrier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Security $security,EntityManagerInterface $entityManager): Response
    {
        $ouvrier = new Ouvrier();
        $user = $security->getUser();
        $ouvrier->setUser($user);
        $form = $this->createForm(OuvrierType::class, $ouvrier);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $file = $form->get('photo')->getData();
            
            if ($file instanceof UploadedFile) {
                $fileName = uniqid().'.'.$file->guessExtension();
    
                // Move the file to the desired directory
                $file->move('img/', $fileName);
    
                // Save the image file name to the entity
                $ouvrier->setphoto($fileName);
            }
    
            // Persist and flush the entity
            $entityManager->persist($ouvrier);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_ouvrier_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('ouvrier/new.html.twig', [
            'ouvrier' => $ouvrier,
            'form' => $form,
        ]);
    }
    

    #[Route('/{idouvrier}', name: 'app_ouvrier_show', methods: ['GET'])]
    public function show(Ouvrier $ouvrier): Response
    {
        return $this->render('ouvrier/show.html.twig', [
            'ouvrier' => $ouvrier,
        ]);
    }
    #[Route('/back/{idouvrier}', name: 'app_ouvrier_showback', methods: ['GET'])]
    public function showback(Ouvrier $ouvrier): Response
    {
        return $this->render('ouvrier/backshow.html.twig', [
            'ouvrier' => $ouvrier,
        ]);
    }

    #[Route('/{idouvrier}/edit', name: 'app_ouvrier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ouvrier $ouvrier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OuvrierType::class, $ouvrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ouvrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ouvrier/edit.html.twig', [
            'ouvrier' => $ouvrier,
            'form' => $form,
        ]);
    }

    #[Route('/{idouvrier}', name: 'app_ouvrier_delete', methods: ['POST'])]
    public function delete(Request $request, Ouvrier $ouvrier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ouvrier->getIdouvrier(), $request->request->get('_token'))) {
            $entityManager->remove($ouvrier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ouvrier_index', [], Response::HTTP_SEE_OTHER);
    }
}
