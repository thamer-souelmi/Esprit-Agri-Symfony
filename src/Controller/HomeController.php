<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController{

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('base.html.twig',);
    }
    #[Route('/home', name: 'app_ban')]
    public function index1(): Response
    {
        return $this->render('security/banned.html.twig',);
    }
    
}