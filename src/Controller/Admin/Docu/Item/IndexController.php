<?php

declare(strict_types=1);

namespace App\Controller\Admin\Docu\Item;

use App\Entity\Docu\Item;
use App\Service\Docs\CatigoryService;
use App\Service\Docs\ItemService;
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

    private const ADMIN_DOCU_ITEMS_ROUTE = 'app_admin_docu_items_index';

    public function __construct(
        private readonly CatigoryService $catigoryService,
        private readonly ItemService $itemService
    ) {
    }

    #[Route('/items/home', name: 'app_admin_docu_items_index')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $items = $this->itemService->getAll();

        return $this->render('admin/docu/items/index.html.twig', [
            'items' => $items
        ]);
    }

    #[Route('/item/new', name: 'app_admin_docu_item_new_form')]
    public function newForm(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $catigories = $this->catigoryService->getAll();

        return $this->render('admin/docu/items/new.html.twig', [
            'catigories' => $catigories
        ]);
    }

    #[Route('/item/save', name: 'app_admin_docu_item_save', methods: 'POST')]
    public function newSave(?string $id, Request $request): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $slug = $this->validate($request->request->get('slug'));
        $content = $this->validateTextarea($request->request->get('content'));

        if (!$slug || !$content) {
            $this->addFlash('warning', 'Name and content are required.');
            return $this->redirectToRoute(self::ADMIN_DOCU_ITEMS_ROUTE);
        }

        $catigory = $this->catigoryService->getById(
            $this->validateNumber($request->request->get('catigoryId'))
        );

        if (!$catigory) {
            $this->addFlash('warning', 'Catigory associated with item could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOCU_ITEMS_ROUTE);
        }

        $item = new Item();

        $this->itemService->save(
            $item
                ->setCatigory($catigory)
                ->setSlug($slug)
                ->setContent($content)
        );

        $this->addFlash('success', 'New item has been added.');

        return $this->redirectToRoute(self::ADMIN_DOCU_ITEMS_ROUTE);
    }

    #[Route('/item/edit/{id}', name: 'app_admin_docu_item_edit')]
    public function edit(?string $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $item = $this->itemService->getById($this->validateNumber($id));

        if (!$item) {
            $this->addFlash('warning', 'Item could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOCU_ITEMS_ROUTE);
        }

        $catigories = $this->catigoryService->getAll();

        return $this->render('admin/docu/items/edit.html.twig', [
            'item' => $item,
            'catigories' => $catigories
        ]);
    }

    #[Route('/item/store/{id}', name: 'app_admin_docu_item_store', methods: 'POST')]
    public function store(?string $id, Request $request): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $slug = $this->validate($request->request->get('slug'));
        $content = $this->validateTextarea($request->request->get('content'));

        if (!$slug || !$content) {
            $this->addFlash('warning', 'Name and content are required.');
            return $this->redirectToRoute(self::ADMIN_DOCU_ITEMS_ROUTE);
        }

        $item = $this->itemService->getById($this->validateNumber($id));

        if (!$item) {
            $this->addFlash('warning', 'Item could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOCU_ITEMS_ROUTE);
        }

        $catigory = $this->catigoryService->getById(
            $this->validateNumber($request->request->get('catigoryId'))
        );

        if (!$catigory) {
            $this->addFlash('warning', 'Catigory associated with item could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOCU_ITEMS_ROUTE);
        }

        $likes = $this->validateNumber($request->request->get('likes'));
        $disLikes = $this->validateNumber($request->request->get('disLikes'));

        $this->itemService->save(
            $item
                ->setCatigory($catigory)
                ->setSlug($slug)
                ->setContent($content)
                ->setLikes($likes)
                ->setDisLikes($disLikes)
        );

        $this->addFlash('success', 'Changes has been saved.');

        return $this->redirectToRoute(self::ADMIN_DOCU_ITEMS_ROUTE);
    }
}
