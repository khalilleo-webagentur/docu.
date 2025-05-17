<?php

declare(strict_types=1);

namespace App\Controller\Admin\Doc\Item;

use App\Entity\Doc\Item;
use App\Helper\Doc\DocHelper;
use App\Service\Doc\CategoryService;
use App\Service\Doc\ItemService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/dashboard/m53j0v1vxa1g8h3yd')]
class IndexController extends AbstractController
{
    use FormValidationTrait;

    private const ADMIN_DOC_ITEMS_ROUTE = 'app_admin_doc_items_index';

    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly ItemService     $itemService
    ){
    }

    #[Route('/items/home', name: 'app_admin_doc_items_index')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $items = $this->itemService->getAll();

        return $this->render('admin/doc/items/index.html.twig', [
            'items' => $items
        ]);
    }

    #[Route('/item/new', name: 'app_admin_doc_item_new')]
    public function newForm(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $categories = $this->categoryService->getAll();

        $readTimes = DocHelper::AVAILABLE_READ_TIMES;

        return $this->render('admin/doc/items/new.html.twig', [
            'categories' => $categories,
            'readTimes' => $readTimes,
        ]);
    }

    #[Route('/item/save', name: 'app_admin_doc_item_save', methods: 'POST')]
    public function newSave(?string $id, Request $request): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $slug = $this->validate($request->request->get('slug'));
        $content = $request->request->get('content');

        if (!$slug || !$content) {
            $this->addFlash('warning', 'Name and content are required.');
            return $this->redirectToRoute(self::ADMIN_DOC_ITEMS_ROUTE);
        }

        $category = $this->categoryService->getById(
            $this->validateNumber($request->request->get('categoryId'))
        );

        if (!$category) {
            $this->addFlash('warning', 'Category associated with item could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOC_ITEMS_ROUTE);
        }

        $readTime = $this->validate($request->request->get('readTime'));

        if (!in_array($readTime, DocHelper::AVAILABLE_READ_TIMES, true)) {
            $readTime = DocHelper::DEFAULT_READ_TIME;
        }

        $item = new Item();

        $this->itemService->save(
            $item
                ->setCategory($category)
                ->setSlug($slug)
                ->setContent($content)
                ->setReadTime($readTime)
        );

        $this->addFlash('success', 'New item has been added.');

        return $this->redirectToRoute(self::ADMIN_DOC_ITEMS_ROUTE);
    }

    #[Route('/item/edit/{id}', name: 'app_admin_doc_item_edit')]
    public function edit(?string $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $item = $this->itemService->getById($this->validateNumber($id));

        if (!$item) {
            $this->addFlash('warning', 'Item could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOC_ITEMS_ROUTE);
        }

        $categories = $this->categoryService->getAll();

        $readTimes = DocHelper::AVAILABLE_READ_TIMES;

        return $this->render('admin/doc/items/edit.html.twig', [
            'item' => $item,
            'categories' => $categories,
            'readTimes' => $readTimes,
        ]);
    }

    #[Route('/item/store/{id}', name: 'app_admin_doc_item_action_store', methods: 'POST')]
    public function store(?string $id, Request $request): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $slug = $this->validate($request->request->get('slug'));
        $content = $request->request->get('content');

        if (!$slug || !$content) {
            $this->addFlash('warning', 'Name and content are required.');
            return $this->redirectToRoute(self::ADMIN_DOC_ITEMS_ROUTE);
        }

        $item = $this->itemService->getById($this->validateNumber($id));

        if (!$item) {
            $this->addFlash('warning', 'Item could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOC_ITEMS_ROUTE);
        }

        $category = $this->categoryService->getById(
            $this->validateNumber($request->request->get('categoryId'))
        );

        if (!$category) {
            $this->addFlash('warning', 'Category associated with item could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOC_ITEMS_ROUTE);
        }

        $likes = $this->validateNumber($request->request->get('likes'));
        $disLikes = $this->validateNumber($request->request->get('disLikes'));

        $readTime = $this->validate($request->request->get('readTime'));

        if (!in_array($readTime, DocHelper::AVAILABLE_READ_TIMES, true)) {
            $readTime = DocHelper::DEFAULT_READ_TIME;
        }

        $this->itemService->save(
            $item
                ->setCategory($category)
                ->setSlug($slug)
                ->setContent($content)
                ->setLikes($likes)
                ->setDisLikes($disLikes)
                ->setReadTime($readTime)
        );

        $this->addFlash('success', 'Changes has been saved.');

        return $this->redirectToRoute(self::ADMIN_DOC_ITEMS_ROUTE);
    }
}
