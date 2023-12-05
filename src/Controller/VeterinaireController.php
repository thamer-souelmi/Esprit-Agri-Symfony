<?php

namespace App\Controller;

use App\Entity\Veterinaire;
use App\Form\ContactFormType;
use App\Form\VeterinaireType;
use App\Mailer\VeterinaryMailer as MailerVeterinaryMailer;
use App\Repository\VeterinaireRepository;
use App\Service\GeocodingService;
use Doctrine\DBAL\Schema\View;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use VeterinaryMailer;

#[Route('/veterinaire')]
class VeterinaireController extends AbstractController
{
    #[Route('/', name: 'app_veterinaire_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $veterinaires = $entityManager
            ->getRepository(Veterinaire::class)
            ->findAll();

        return $this->render('veterinaire/indexv.html.twig', [
            'veterinaires' => $veterinaires,
        ]);
    }
    


    #[Route('/vet', name: 'frontaffich', methods: ['GET'])]
    public function frontvet(EntityManagerInterface $entityManager): Response
    {
        $veterinaires = $entityManager
            ->getRepository(Veterinaire::class)
            ->findAll();

        return $this->render('veterinaire/index.html.twig', [
            'veterinaires' => $veterinaires,
        ]);
    }

    #[Route('/vetcontact/{id}', name: 'contactvet', methods: ['GET'])]
    public function contactVet($id, VeterinaireRepository $veterinaireRepository)
{
    $veterinaire = $veterinaireRepository->find($id);

    return $this->render('veterinaire/contact.html.twig', [
        'veterinaire' => $veterinaire,
    ]);
}
#[Route('/search/veterinaire', name: 'veterinaire_search', methods: ['GET'])]
public function search(Request $request, VeterinaireRepository $veterinaireRepository): Response
{
    $searchQuery = $request->query->get('search_query');


    $resultats = $veterinaireRepository->searchByNomPrenomAdresse($searchQuery);

    return $this->render('veterinaire/search_results.html.twig', [
        'veterinaires' => $resultats,
    ]);
}


    #[Route('/new', name: 'app_veterinaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $veterinaire = new Veterinaire();
        $form = $this->createForm(VeterinaireType::class, $veterinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('specialite')->getData();
        
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
                $veterinaire->setSpecialite($newFilename);
            }
            
            $entityManager->persist($veterinaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veterinaire/new.html.twig', [
            'veterinaire' => $veterinaire,
            'form' => $form,
        ]);
    }

    #[Route('/{idvet}', name: 'app_veterinaire_show', methods: ['GET'])]
    public function show(Veterinaire $veterinaire): Response
    {
        return $this->render('veterinaire/show.html.twig', [
            'veterinaire' => $veterinaire,
        ]);
    }
    

    #[Route('/{idvet}/edit', name: 'app_veterinaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Veterinaire $veterinaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeterinaireType::class, $veterinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veterinaire/edit.html.twig', [
            'veterinaire' => $veterinaire,
            'form' => $form,
        ]);
    }

    #[Route('/{idvet}', name: 'app_veterinaire_delete', methods: ['POST'])]
    public function delete(Request $request, Veterinaire $veterinaire, VeterinaireRepository $veterinaireRepository): Response
    {
        if ($veterinaireRepository->isVeterinaireInUse($veterinaire)) {
            $this->addFlash('danger', 'Le véterinaire a au  moins un traitement médical. Suppression impossible.');
        }
        else{
        if ($this->isCsrfTokenValid('delete'.$veterinaire->getIdvet(), $request->request->get('_token'))) {
            $veterinaireRepository->remove($veterinaire, true);
                $this->addFlash('success', 'Le véterinaire a été supprimée avec succès.');
            } else {
                $this->addFlash('danger', 'Le jeton CSRF n\'est pas valide. Suppression impossible.');
            }
        }
        return $this->redirectToRoute('app_veterinaire_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/search', name: 'app_veterinaire_search', methods: ['GET'])]
    public function searchback(Request $request, VeterinaireRepository $veterinaireRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        // Call a method in your repository to perform the search
        $veterinaires =$veterinaireRepository->searchByTerm($searchTerm);

        return $this->render('veterinaire/indexv.html.twig', [
            'veterinaires' => $veterinaires,
        ]);
    }






/*


    #[Route('/{idvettgeo}', name: 'app_geo')]
public function yourAction(GeocodingService $geocodingService, VeterinaireRepository $veterinaireRepository, int $idvettgeo): Response
{
    // Assuming $veterinaire is your veterinarian entity
    $veterinaire = $veterinaireRepository->find($idvettgeo);

    if (!$veterinaire) {
        throw $this->createNotFoundException('Veterinaire not found');
    }

    $address = $veterinaire->getAdresscabinet();

    // Call the geocoding service to get coordinates
    $coordinates = $geocodingService->getCoordinates($address);

    // Render the contact.html.twig template with the coordinates
    return $this->render('veterinaire/contact.html.twig', [
        'veterinaire' => $veterinaire,
        'coordinates' => $coordinates,
    ]);
}
*/

/*
    #[Route('/contact/{id}', name: 'contact_form')]
    public function contactForm(Request $request, MailerVeterinaryMailer $veterinaryMailer, Veterinaire $veterinaire): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            // Envoyer l'e-mail au vétérinaire
            $veterinaryMailer->sendContactForm(
                'malek.frikhi@esprit.tn', // Remplacez par l'e-mail du vétérinaire
                $formData['subject'],
                $formData['name'],
                $formData['email'],
                $formData['message']
            );

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');
        }

        return $this->render('veterinaire/contact.html.twig', ['form' => $form->createView(),
        'veterinaire' => $veterinaire, ]);
    }
    */
    #[Route('/sendEmail/{id}', name: 'send_email', methods: ['POST'])]
    public function sendEmail(Request $request, MailerInterface $mailer, Veterinaire $veterinaire): Response
    {
        $fname = $request->request->get('fname');
        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $message = $request->request->get('message');
    
        // Render the Twig template
        $emailContent = $this->renderView('veterinaire/mailtemplate.html.twig', [
            'fname' => $fname,
            'subject' => $subject,
            'message' => $message,
            'email' => $email,
        ]);
    
        // Send the email
        $email = (new Email())
            ->from('malek.frikhi@esprit.tn')
            ->to('agriesprit3@gmail.com')
            ->subject('Rendez-vous')
            ->html($emailContent);
    
        $mailer->send($email);
    
        return $this->redirectToRoute('contactvet', ['id' => $veterinaire->getIdvet()]);
    }

    
    #[Route('/graphique/veterinaires-par-ville', name: 'graphique_veterinaires_par_ville')]
    public function graphiqueVeterinairesParVille(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Veterinaire::class)->countVeterinairesParVille();

        return $this->render('veterinaire/graphiqueveterinairesparville.html.twig', [
            'data' => $data,
        ]);
    }
}
