<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, AuthorizationCheckerInterface $authorizationChecker, UserRepository $userRepository): Response
{
    if ($this->getUser()) {
        $roles = $this->getUser()->getRoles();
        
        if (in_array('admin', $roles)) {
            return $this->redirectToRoute('app_user_index');
        } else {
            return $this->redirectToRoute('app_home');
        }
    }

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    // Check if the user is banned
    $user = $userRepository->findOneBy(['mail' => $lastUsername, 'isBanned' => 0]);
    $user = $userRepository->findOneBy(['mail' => $lastUsername]);

    if ($user) {
        if ($user->isBanned()) {
            // User is banned, return a message or redirect accordingly
            return $this->render('security/banned.html.twig');
        }
        
        // User is not banned, proceed to render login template
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    // if ($user && $user->isBanned()) {
    //     // User is banned, return a message or redirect accordingly
    //     return $this->render('security/banned.html.twig');
    // }

    return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error,'user' =>$user]);
}

    

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
