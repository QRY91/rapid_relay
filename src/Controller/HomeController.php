<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
    #[Route('/guide', name: 'app_home_guide', methods: ['GET'])]
    public function guide(): Response
    {
        return $this->render('home/guide.html.twig');
    }
}
