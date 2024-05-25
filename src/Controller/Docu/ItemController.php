<?php

namespace App\Controller\Docu;

use App\Service\Docs\CatigoryService;
use App\Service\Docs\ItemService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ItemController extends AbstractController
{
    use FormValidationTrait;

    public function __construct(
        private readonly CatigoryService $catigoryService,
        private readonly ItemService $itemService
    ) {
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

    #[Route('/rate', name: 'app_docu_item_rate_store', methods: 'POST')]
    public function rateItem(Request $request): RedirectResponse
    {
        $item = $this->itemService->getById($this->validateNumber(
            $request->request->get('id')
        ));

        $uri = $this->validate($request->request->get('uri'));

        if ($item && $this->validateCheckbox($request->request->get('like'))) {
            $this->itemService->save(
                $item->setLikes($item->getLikes() + 1)
            );
        }

        if ($item && $this->validateCheckbox($request->request->get('disLike'))) {
            $this->itemService->save(
                $item
                    ->setLikes($item->getLikes() > 1 ? $item->getLikes() - 1 : 0)
                    ->setDisLikes($item->getDisLikes() + 1)
            );
        }

        return $this->redirect($uri);
    }
}
