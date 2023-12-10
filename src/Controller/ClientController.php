<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\ClientType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Endroid\QrCode\QrCode;
use App\Repository\ClientRepository;
use Endroid\QrCode\Writer\PngWriter;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Security;

#[Route('/client')]
class ClientController extends AbstractController
{

    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $clients = $entityManager
            ->getRepository(Produit::class)
            ->findAll();

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }
    //QR CODE 

    #[Route('/generate-qr/{id}', name: 'app_client_generate_qr', methods: ['GET'])]
    public function generateQrCodeForClient($id, ProduitRepository $clientRepository): Response
    {
        $client = $clientRepository->find($id);

        // Générer le contenu du QR Code (utilisez toutes les informations du client)
        $qrContent = sprintf(
            "Nom du produit: %s\nPrix: %s\nQuantité: %s",
            $client->getNomprod(),
            $client->getPrix(),
            $client->getQte()
        );

        // Créer une instance de QrCode
        $qrCode = new QrCode($qrContent);

        // Créer une instance de PngWriter pour générer le résultat sous forme d'image PNG
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Créer une réponse avec le résultat du QR Code
        $response = new Response($result->getString(), Response::HTTP_OK, [
            'Content-Type' => $result->getMimeType(),
        ]);

        return $response;
    }
    //QR CODE 


    //BARRE CODE
    #[Route('/generate-barcode/{id}', name: 'app_client_generate_barcode', methods: ['GET'])]
    public function generateBarcodeForClient($id, ProduitRepository $clientRepository): Response
    {
        $client = $clientRepository->find($id);

        // Générer le contenu du code-barres (utilisez toutes les informations du client)
        $barcodeContent = sprintf(
            "Nom du produit: %s\nPrix: %s\nQuantité: %s",
            $client->getNomprod(),
            $client->getPrix(),
            $client->getQte()
        );

        // Créer une instance de BarcodeGeneratorHTML
        $generator = new BarcodeGeneratorHTML();

        // Générer le code-barres HTML
        $barcodeHtml = $generator->getBarcode($barcodeContent, $generator::TYPE_CODE_128);

        // Créer une réponse avec le code-barres HTML
        $response = new Response($barcodeHtml, Response::HTTP_OK, [
            'Content-Type' => 'text/html',
        ]);

        return $response;
    }
    // #[Route('/generate-barcode/{id}', name: 'app_client_generate_barcode', methods: ['GET'])]
    // public function generateBarcodeForClient($id, ClientRepository $clientRepository): Response
    // {
    //     $client = $clientRepository->find($id);

    //     // Générer le contenu du code-barres (utilisez toutes les informations du client)
    //     $barcodeContent = sprintf(
    //         "Nom du produit: %s\nPrix: %s\nQuantité: %s",
    //         $client->getNomprod(),
    //         $client->getPrix(),
    //         $client->getQte()
    //     );

    //     // Créer une instance de BarcodeGeneratorHTML
    //     $generator = new BarcodeGeneratorHTML();

    //     // Générer le code-barres HTML
    //     $barcodeHtml = $generator->getBarcode($barcodeContent, $generator::TYPE_CODE_128);

    //     // Rendre le modèle Twig associé avec les données nécessaires
    //     return $this->render('client/codebarre.html.twig', [
    //         'barcodeHtml' => $barcodeHtml,
    //     ]);
    // }
    //DANSN UNE TWIG
    //DANS UNE FLASH
    //   #[Route('/generate-barcode/{id}', name: 'app_client_generate_barcode', methods: ['GET'])]
    // public function generateBarcodeForClient($id, ClientRepository $clientRepository, SessionInterface $session): Response
    // {
    //     $client = $clientRepository->find($id);

    //     // Générer le contenu du code-barres (utilisez toutes les informations du client)
    //     $barcodeContent = sprintf(
    //         "Nom du produit: %s\nPrix: %s\nQuantité: %s",
    //         $client->getNomprod(),
    //         $client->getPrix(),
    //         $client->getQte()
    //     );

    //     // Créer une instance de QrCode
    //     $qrCode = new QrCode($barcodeContent);

    //     // Chemin d'enregistrement du fichier image du code-barres
    //     $barcodeImagePath = '/path/to/save/barcode/' . $id . '_barcode.png';

    //     // Enregistrer l'image du code-barres
    //     $qrCode->writeFile($barcodeImagePath);

    //     // Save the barcode image path in the session
    //     $session->set('barcode_image', $barcodeImagePath);

    //     // Flash message
    //     $this->addFlash('barcode', 'Barcode generated successfully!');

    //     // Redirect back to the page
    //     return $this->redirectToRoute('app_client_index');
    // }


    //BARRE CODE
    #[Route('/back', name: 'app_clientback_index', methods: ['GET'])]
    public function indexback(EntityManagerInterface $entityManager): Response
    {
        $clients = $entityManager
            ->getRepository(Produit::class)
            ->findAll();

        return $this->render('client/indexback.html.twig', [
            'clients' => $clients,
        ]);
    }



    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Security $security, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $client = new Client();
        // $user = new User();
        // $user = $entityManager->getRepository(User::class)->find(7);
        $client->setIdUser(11);
        $client->setProdid(12);

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

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
                $client->setImage($newFilename);
            }

            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/download-barcode/{id}', name: 'download_barcode')]
    public function downloadBarcode($id): Response
    {
        // Retrieve the client based on the ID (adjust as needed)
        $client = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        if (!$client) {
            throw $this->createNotFoundException('Client not found');
        }

        $barcodeContent = sprintf(
            "Nom du produit: %s\nPrix: %s\nQuantité: %s",
            $client->getNomprod(),
            $client->getPrix(),
            $client->getQte()
        );

        $generator = new BarcodeGeneratorHTML();

        // Générer le code-barres HTML
        $barcodeHtml = $generator->getBarcode($barcodeContent, $generator::TYPE_CODE_128);

        // Create a response with the barcode content
        $response = new Response($barcodeHtml);

        // Set headers for downloading the file
        $response->headers->set('Content-Type', 'text/html');
        $response->headers->set('Content-Disposition', 'attachment; filename="barcode.html"');

        return $response;
    }

    #[Route('/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
    //partie back

    #[Route('/new/back', name: 'app_clientback_new', methods: ['GET', 'POST'])]
    public function newback(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

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
                $client->setImage($newFilename);
            }

            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_clientback_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/newback.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }


    #[Route('/back/{id}', name: 'app_clientback_show', methods: ['GET'])]
    public function showback(Client $client): Response
    {
        return $this->render('client/showback.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/{id}/edit/back', name: 'app_clientback_edit', methods: ['GET', 'POST'])]
    public function editback(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_clientback_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/editback.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/back/{id}', name: 'app_clientback_delete', methods: ['POST'])]
    public function deleteback(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_clientback_index', [], Response::HTTP_SEE_OTHER);
    }
}