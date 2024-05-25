<?php

namespace App\Controller\Docu;

use App\Service\Docs\CatigoryService;
use App\Service\Docs\ItemService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatigoryController extends AbstractController
{
    use FormValidationTrait;

    public function __construct(
        private readonly CatigoryService $catigoryService,
        private readonly ItemService $itemService
    ) {
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
}
