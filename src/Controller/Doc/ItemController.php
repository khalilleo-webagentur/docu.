<?php

namespace App\Controller\Doc;

use App\Service\Doc\CategoryService;
use App\Service\Doc\ItemService;
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
        private readonly CategoryService $categoryService,
        private readonly ItemService     $itemService
    ) {
    }

    #[Route('/i/{slug}', name: 'app_doc_item_name_index')]
    public function item(?string $slug): Response
    {
        $slug = $this->validate($slug);

        $slug = str_replace('-', ' ', $slug);

        $item = $this->itemService->getOneBySlug($slug);

        $category = $this->categoryService->getFirstOne();

        if ($item) {
            $category = $item->getCategory();
        }

        $categories = $this->categoryService->getAll();

        return $this->render('doc/show.html.twig', [
            'item' => $item,
            'category' => $category,
            'categories' => $categories,
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
