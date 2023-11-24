<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    // public function index(EntityManagerInterface $entityManager, Security $security): Response
    // {
    //     $user = $security->getUser();
        
    //         $id = $user->getId(); // Assuming getId() returns the user's ID
    //         $produits = $entityManager
    //             ->getRepository(Produit::class)
    //             ->findByUserId($id);

    //         return $this->render('produit/index.html.twig', [
    //             'produits' => $produits,
    //         ]);
    // }
    public function index(ProduitRepository $produitRepository,PaginatorInterface $paginator,Request $request): Response
    {   $produit = $produitRepository->findAll();
        $pagination = $paginator->paginate(
            $produit,
            $request->query->getInt('page', 1),
            4 // Number of items per page
        );
        return $this->render('produit/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    // #[Route('/back', name: 'app_produit_indexb', methods: ['GET'])]
    // public function indexb(EntityManagerInterface $entityManager): Response
    // {
    //     $produits = $entityManager
    //         ->getRepository(Produit::class)
    //         ->findAll();

    //     return $this->render('produit/indexb.html.twig', [
    //         'produits' => $produits,
    //     ]);
    // }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,Security $security,SluggerInterface $slugger): Response
    {
        $produit = new Produit();
        $user = $security->getUser();
        $produit->setUser($user);
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /** @var UploadedFile $imageFile */
             $imageFile = $form->get('image')->getData();
        
             if ($imageFile) {
                 $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                 $safeFilename = $slugger->slug($originalFilename);
                 $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
     
                 // Move the file to the directory where your images are stored
                 try {
                     $imageFile->move(
                         $this->getParameter('img_directory'),
                         $newFilename
                     );
                 } catch (FileException $e) {
                     // Handle the exception if something happens during the file upload
                 }
     
                 // Update the 'image' property to store the file name instead of its contents
                 $produit->setImage($newFilename);
             }
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }
    #[Route('/back/{id}', name: 'app_produit_showb', methods: ['GET'])]
    public function showb(Produit $produit): Response
    {
        return $this->render('produit/showb.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /** @var UploadedFile $imageFile */
             $imageFile = $form->get('image')->getData();
        
             if ($imageFile) {
                 $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                 $safeFilename = $slugger->slug($originalFilename);
                 $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
     
                 // Move the file to the directory where your images are stored
                 try {
                     $imageFile->move(
                         $this->getParameter('img_directory'),
                         $newFilename
                     );
                 } catch (FileException $e) {
                     // Handle the exception if something happens during the file upload
                 }
     
                 // Update the 'image' property to store the file name instead of its contents
                 $produit->setImage($newFilename);
             }
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
