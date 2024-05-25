<?php

namespace App\Controller\Docu;

use App\Service\Docs\CatigoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly CatigoryService $catigoryService
    ) {
    }

    #[Route('/', name: 'app_docu_home')]
    public function index(): Response
    {
        $catigories = $this->catigoryService->getAll();

        return $this->render('index.html.twig', [
            'catigories' => $catigories
        ]);
    }
}
