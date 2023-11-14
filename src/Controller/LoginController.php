<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
   // #[Route('/login', name: 'app_login')]
    #[Route("/login123", name:"app_login", methods:["GET", "POST"])]
    public function login(Request $request, \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Retrieve any login errors
        $error = $authenticationUtils->getLastAuthenticationError();
    
        // Retrieve the last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
    
        // Handling login information
        $email = $request->request->get('email');
        $password = $request->request->get('password');
    
        // Verify the login credentials
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['mail' => $email]);
    
        // if ($user && $password->isPasswordValid($user, $password)) {
        //     return $this->redirectToRoute('user_dashboard'); // Assuming 'user_dashboard' is the route to the user dashboard
        // } else {
        //     // Handle login errors here, for example, by setting flash messages
        //     $this->addFlash('error', 'Invalid email or password. Please try again.');
        //    // return $this->redirectToRoute('app_login');
        // }
        

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
