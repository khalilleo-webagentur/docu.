<?php

namespace App\Controller\Docu;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_docu_home')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/details', name: 'app_docu_details')]
    public function show(): Response
    {
        return $this->render('docu/details.html.twig');
    }
}
