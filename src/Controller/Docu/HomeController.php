<?php

namespace App\Controller\Docu;

use App\Service\Docs\CatigoryService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    use FormValidationTrait;

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

    #[Route('/c/{name}', name: 'app_docu_catigory_name')]
    public function catigory(?string $name): Response
    {
        $name = $this->validate($name);

        $catigory = $this->catigoryService->getOneByName($name);

        if (!$catigory) {
            $catigory = $this->catigoryService->getFirstOne();
        }

        return $this->render('docu/show.html.twig', [
            'catigory' => $catigory
        ]);
    }

    #[Route('/details', name: 'app_docu_details')]
    public function show(): Response
    {
        return $this->render('docu/details.html.twig');
    }
}
