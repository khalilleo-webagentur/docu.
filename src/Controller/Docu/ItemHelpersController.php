<?php

namespace App\Controller\Docu;

use App\Service\Docs\ItemService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ItemHelpersController extends AbstractController
{
    use FormValidationTrait;

    public function __construct(
        private readonly ItemService $itemService
    ) {
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
