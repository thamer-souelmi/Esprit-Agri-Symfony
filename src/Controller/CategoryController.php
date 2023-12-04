<?php

namespace App\Controller;

use App\Service\TwilioService;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{

    #[Route('/', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    #[Route('/back', name: 'app_categoryback_index', methods: ['GET'])]
    public function indexback(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/indexback.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
    //back section


    #[Route('/back/new', name: 'app_categoryback_new', methods: ['GET', 'POST'])]
    public function newback(Request $request, CategoryRepository $categoryRepository, TwilioService $twilioService): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);
            $to = '+21652474552'; // Static phone number

            // $message = 'New category created: ' . $category->getType(); // Modify the message as needed
            // $twilioService->sendSMS($to, $message);
            return $this->redirectToRoute('app_categoryback_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/newback.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/back/{id}', name: 'app_categoryback_show', methods: ['GET'])]
    public function showback(Category $category): Response
    {
        return $this->render('category/showback.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/back/{id}/edit', name: 'app_categoryback_edit', methods: ['GET', 'POST'])]
    public function editback(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_categoryback_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/editback.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/back/{id}', name: 'app_categoryback_delete', methods: ['POST'])]
    public function deleteback(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        // Ajouter la vérification si la catégorie est utilisée par une culture
        if ($categoryRepository->isCategoryInUse($category)) {
            $this->addFlash('danger', 'La catégorie est utilisée par au moins une culture. Suppression impossible.');
        } else {
            // Supprimer la catégorie si le jeton CSRF est valide et qu'elle n'est pas utilisée par une culture
            if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
                $categoryRepository->remove($category, true);
                $this->addFlash('success', 'La catégorie a été supprimée avec succès.');
            } else {
                $this->addFlash('danger', 'Le jeton CSRF n\'est pas valide. Suppression impossible.');
            }
        }

        return $this->redirectToRoute('app_categoryback_index', [], Response::HTTP_SEE_OTHER);
    }
}
