<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private LoggerInterface $logger;

    public function __construct(EmailVerifier $emailVerifier,LoggerInterface $logger)
    {
        $this->emailVerifier = $emailVerifier;
        $this->logger = $logger;
    }
    

    #[Route('/mail', name: 'mail')]
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('espritagri1@gmail.com')
            ->to('nasriamin300@gmail.com')
            ->subject('amin')
            ->text('amin');
        // ->html('<p>Contenu du message en HTML</p>');

        try {
            $mailer->send($email);
            // Envoyé avec succès, vous pouvez renvoyer une réponse de succès
            return new Response('Email envoyé avec succès!');
        } catch (\Exception $e) {
            // En cas d'échec, renvoyez un message d'erreur ou utilisez un gestionnaire d'erreurs
            return new Response('Erreur lors de l\'envoi de l\'email : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $imageFile */
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

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('espritagri11@gmail.com', 'Esprit Agri'))
                    ->to($user->getMail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            
            // do anything else you need here, like send an email
             $this->logger->info('Verification email sent.');

            // return $userAuthenticator->authenticateUser(
            //     $user,
            //     $authenticator,
            //     $request
            // );
         }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_login');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
