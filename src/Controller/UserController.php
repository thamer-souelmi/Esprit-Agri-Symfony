<?php

namespace App\Controller;

use App\Entity\User;
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
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

        #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
        public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
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
        
                $entityManager->persist($user);
                $entityManager->flush();
        
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
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

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UserType::class, $user);
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
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    
   

}
