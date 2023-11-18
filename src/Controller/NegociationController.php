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

#[Route('/negociation')]
class NegociationController extends AbstractController
{
    #[Route('/', name: 'app_negociation_index', methods: ['GET'])]
    public function index(NegociationRepository $negociationRepository): Response
    {
        return $this->render('negociation/index.html.twig', [
            'negociations' => $negociationRepository->findAll(),
        ]);
    }
     /////////////////////////////BACK//////////////////////////////////////////
     #[Route('/backnego', name: 'app_negociation_index_back', methods: ['GET'])]
    public function indexNego(NegociationRepository $negociationRepository): Response
    {
        return $this->render('BACKnego/index.html.twig', [
            'negociations' => $negociationRepository->findAll(),
        ]);
    }
      /////////////////////////////BACK//////////////////////////////////////////

    #[Route('/new/{idannonce}', name: 'app_negociation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,$idannonce): Response
    {
        $annonceinvestissement = $entityManager->getRepository(Annonceinvestissement::class)->find($idannonce);
        $negociation = new Negociation();
        $negociation ->setIdannonce($annonceinvestissement);
        $currentDate = new \DateTime();
        $negociation->setDatenegociation($currentDate);
        $form = $this->createForm(NegociationType::class, $negociation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($negociation);
            $entityManager->flush();

            return $this->redirectToRoute('app_negociation_index', [], Response::HTTP_SEE_OTHER);
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


    #[Route('/{idannonce}', name: 'app_negociation_show', methods: ['GET'])]
    /*public function show(Negociation $negociation): Response
    {
        return $this->render('negociation/show.html.twig', [
            'negociation' => $negociation,
        ]);
    }*/
    public function afficherNegociations(int $idannonce): Response
    {
        // Fetch the necessary data based on the $idannonce
        $negociations = $this->getDoctrine()->getRepository(Negociation::class)->findBy(['idannonce' => $idannonce]);

        // You can do additional processing or fetch more data if needed

        return $this->render('negociation/index.html.twig', [
            'negociations' => $negociations,
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
    /**
 * @Route("/etat/{id}/{decision}", name="app_nego_decision", methods={"GET"})
 */
public function handleNegociationDecision(int $id, string $decision, EntityManagerInterface $entityManager): RedirectResponse
{
    // Check if the user is an admin (you can implement your own logic to check admin access)

    $negociation = $entityManager->getRepository(Negociation::class)->find($id);
    //var_dump($negociation);
    //die;
    if (!$negociation) {
        throw $this->createNotFoundException('Negociation not found');
    }

    // Update the candidacy's "accepte" field based on the admin's decision
    if ($decision === 'accept') {
        $negociation->setEtatnego(true);
        
    } elseif ($decision === 'refuse') {
        $negociation->setEtatnego(false);
    }

    $entityManager->flush();

    $this->addFlash('success', 'Negociation decision has been saved.');

    // Redirect the admin back to the page that displays the candidates for the specific concours
    // You might want to replace 'your_route_name' with the actual route name you want to redirect to
    return $this->redirectToRoute('app_negociation_index');
}
}
