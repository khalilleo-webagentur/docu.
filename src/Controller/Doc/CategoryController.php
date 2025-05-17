<?php

namespace App\Controller\Doc;

use App\Service\Doc\CategoryService;
use App\Service\Doc\ItemService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    use FormValidationTrait;

    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly ItemService     $itemService
    ){
    }

    #[Route('/c/{name}', name: 'app_doc_category_name_index')]
    public function category(?string $name): Response
    {
        $name = $this->validate($name);

        $category = $this->categoryService->getOneByName($name);

        if (!$category) {
            $category = $this->categoryService->getFirstOne();
        }

        $item = $this->itemService->getFirstOneByCategory($category);

        $categories = $this->categoryService->getAll();

        return $this->render('doc/show.html.twig', [
            'category' => $category,
            'categories' => $categories,
            'item' => $item,
            'slug' => $item ? $item->getSlug() : ''
        ]);
    }
}
