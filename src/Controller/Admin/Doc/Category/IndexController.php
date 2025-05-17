<?php

declare(strict_types=1);

namespace App\Controller\Admin\Doc\Category;

use App\Entity\Doc\Category;
use App\Service\Doc\CategoryService;
use App\Service\Doc\ItemService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/dashboard/l73o8v1vxa1g8h2ya')]
class IndexController extends AbstractController
{
    use FormValidationTrait;

    private const DASHBOARD_DOC_CATEGORIES_ROUTE = 'app_admin_doc_categories_index';

    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly ItemService     $itemService
    ){
    }

    #[Route('/categories/home', name: 'app_admin_doc_categories_index')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $categories = $this->categoryService->getAll();

        return $this->render('admin/doc/categories/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/category/new', name: 'app_admin_doc_category_new', methods: 'POST')]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $name = $this->validate($request->request->get('name'));

        $description = $this->validateTextarea($request->request->get('description'));

        if (!$name || !$description) {
            $this->addFlash('warning', 'Name and description are required.');
            return $this->redirectToRoute(self::DASHBOARD_DOC_CATEGORIES_ROUTE);
        }

        $category = $this->categoryService->getOneByName($this->validate($name));

        if ($category) {
            $this->addFlash('warning', 'Category is already exists.');
            return $this->redirectToRoute(self::DASHBOARD_DOC_CATEGORIES_ROUTE);
        }

        $category = new Category();

        $this->categoryService->save(
            $category
                ->setName($name)
                ->setDescription($description)
        );

        $this->addFlash('success', 'Changes has been saved.');

        return $this->redirectToRoute(self::DASHBOARD_DOC_CATEGORIES_ROUTE);
    }

    #[Route('/category/edit/{id}', name: 'app_admin_doc_category_edit')]
    public function edit(?string $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $category = $this->categoryService->getById($this->validateNumber($id));

        if (!$category) {
            $this->addFlash('warning', 'Category could not be found.');
            return $this->redirectToRoute(self::DASHBOARD_DOC_CATEGORIES_ROUTE);
        }

        $items = $this->itemService->getAllByCategory($category);

        return $this->render('admin/doc/categories/edit.html.twig', [
            'category' => $category,
            'itemsCount' => count($items)
        ]);
    }

    #[Route('/category/store/{id}', name: 'app_admin_doc_category_store', methods: 'POST')]
    public function store(?string $id, Request $request): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $name = $this->validate($request->request->get('name'));

        $description = $this->validateTextarea($request->request->get('description'));

        if (!$name || !$description) {
            $this->addFlash('warning', 'Name and description are required.');
            return $this->redirectToRoute(self::DASHBOARD_DOC_CATEGORIES_ROUTE);
        }

        $category = $this->categoryService->getById($this->validateNumber($id));

        if (!$category) {
            $this->addFlash('warning', 'Category could not be found.');
            return $this->redirectToRoute(self::DASHBOARD_DOC_CATEGORIES_ROUTE);
        }

        $this->categoryService->save(
            $category
                ->setName($name)
                ->setDescription($description)
        );

        $this->addFlash('success', 'Changes has been saved.');

        return $this->redirectToRoute(self::DASHBOARD_DOC_CATEGORIES_ROUTE);
    }
}
