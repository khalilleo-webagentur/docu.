<?php

namespace App\Controller\Docu;

use App\Service\Docs\CatigoryService;
use App\Service\Docs\ItemService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    use FormValidationTrait;

    public function __construct(
        private readonly CatigoryService $catigoryService,
        private readonly ItemService $itemService
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

        $item = $this->itemService->getFirstOneByCatigory($catigory);

        $catigories = $this->catigoryService->getAll();

        return $this->render('docu/show.html.twig', [
            'catigory' => $catigory,
            'catigories' => $catigories,
            'item' => $item,
            'slug' => $item ? $item->getSlug() : ''
        ]);
    }

    #[Route('/details', name: 'app_docu_details')]
    public function show(): Response
    {
        return $this->render('docu/details.html.twig');
    }

    #[Route('/i/{slug}', name: 'app_docu_item_name')]
    public function item(?string $slug): Response
    {
        $slug = $this->validate($slug);

        $slug = str_replace('-', ' ', $slug);

        $item = $this->itemService->getOneBySlug($slug);

        $catigory = $this->catigoryService->getFirstOne();

        if ($item) {
            $catigory = $item->getCatigory();
        }

        $catigories = $this->catigoryService->getAll();

        return $this->render('docu/show.html.twig', [
            'item' => $item,
            'catigory' => $catigory,
            'catigories' => $catigories,
            'slug' => $slug ?? ''
        ]);
    }
}
