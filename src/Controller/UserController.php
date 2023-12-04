<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\ProduitType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index1(): Response
    {
        return $this->render('base.html.twig',);
    }
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager,UserRepository $userRepository): Response
    {
        //$this->denyAccessUnlessGranted('admin', null, 'Access denied!');
        $usersRepository = $entityManager->getRepository(User::class);
        $users = $usersRepository->findByRoles('admin');
        $count = $userRepository->getUsersWithMoreThanFiveReclamationsCount(); 
    
        


    return $this->render('user/index.html.twig', [
        'users' => $users,
        'count' => $count,
    ]);
    }
    #[Route('/produit', name: 'app_produit_indexb', methods: ['GET'])]
    public function indexb(EntityManagerInterface $entityManager): Response
    {
        $produits = $entityManager
            ->getRepository(Produit::class)
            ->findAll();

        return $this->render('produit/indexb.html.twig', [
            'produits' => $produits,
        ]);
    }
    #[Route('produit/{id}/edit', name: 'app_produit_editb', methods: ['GET', 'POST'])]
    public function editprod(Request $request, Produit $produit, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
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

            return $this->redirectToRoute('app_produit_indexb', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/editb.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

        #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
        public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, UserPasswordEncoderInterface $passwordEncoder): Response
        {
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var UploadedFile $imageFile */
                $imageFile = $form->get('image')->getData();
    
                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
    
                    
                        $imageFile->move(
                            $this->getParameter('img_directory'),
                            $newFilename
                        );
                    
    
                    $user->setImage($newFilename);
                }
    
                
                $hashedPassword = hash('sha1', $user->getPassword());
                $user->setMdp($hashedPassword);
    
                $entityManager->persist($user);
                $entityManager->flush();
    
                return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
            }
    
            return $this->render('user/new.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }
    

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_editf', methods: ['GET', 'POST'])]
    public function editf(Request $request, User $user, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $user = $this->getUser(); 
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
                   $user->setImage($newFilename);
               }
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/editf.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $user = $this->getUser(); 
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
                   $user->setImage($newFilename);
               }
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getid(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
    

    
   

}
