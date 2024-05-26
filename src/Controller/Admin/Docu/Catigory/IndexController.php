<?php

declare(strict_types=1);

namespace App\Controller\Admin\Docu\Catigory;

use App\Entity\Docu\Catigory;
use App\Service\Docs\CatigoryService;
use App\Service\Docs\ItemService;
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

    private const ADMIN_DOCU_CATIGORIES_ROUTE = 'app_admin_docu_catigories_index';

    public function __construct(
        private readonly CatigoryService $catigoryService,
        private readonly ItemService $itemService
    ) {
    }

    #[Route('/catigories/home', name: 'app_admin_docu_catigories_index')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $catigories = $this->catigoryService->getAll();

        return $this->render('admin/docu/catigories/index.html.twig', [
            'catigories' => $catigories
        ]);
    }

    #[Route('/catigory/new', name: 'app_admin_docu_catigory_new', methods: 'POST')]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $name = $this->validate($request->request->get('name'));

        $description = $this->validateTextarea($request->request->get('description'));

        if (!$name || !$description) {
            $this->addFlash('warning', 'Name and description are required.');
            return $this->redirectToRoute(self::ADMIN_DOCU_CATIGORIES_ROUTE);
        }

        $catigory = $this->catigoryService->getOneByName($this->validate($name));

        if ($catigory) {
            $this->addFlash('warning', 'Catigory is already exists.');
            return $this->redirectToRoute(self::ADMIN_DOCU_CATIGORIES_ROUTE);
        }

        $catigory = new Catigory();

        $this->catigoryService->save(
            $catigory
                ->setName($name)
                ->setDescription($description)
        );

        $this->addFlash('success', 'Changes has been saved.');

        return $this->redirectToRoute(self::ADMIN_DOCU_CATIGORIES_ROUTE);
    }

    #[Route('/catigory/edit/{id}', name: 'app_admin_docu_catigory_edit')]
    public function edit(?string $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $catigory = $this->catigoryService->getById($this->validateNumber($id));

        if (!$catigory) {
            $this->addFlash('warning', 'Catigory could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOCU_CATIGORIES_ROUTE);
        }

        $items = $this->itemService->getAllByCatigory($catigory);

        return $this->render('admin/docu/catigories/edit.html.twig', [
            'catigory' => $catigory,
            'itemsCount' => count($items)
        ]);
    }

    #[Route('/catigory/store/{id}', name: 'app_admin_docu_catigory_store', methods: 'POST')]
    public function store(?string $id, Request $request): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $name = $this->validate($request->request->get('name'));

        $description = $this->validateTextarea($request->request->get('description'));

        if (!$name || !$description) {
            $this->addFlash('warning', 'Name and description are required.');
            return $this->redirectToRoute(self::ADMIN_DOCU_CATIGORIES_ROUTE);
        }

        $catigory = $this->catigoryService->getById($this->validateNumber($id));

        if (!$catigory) {
            $this->addFlash('warning', 'Catigory could not be found.');
            return $this->redirectToRoute(self::ADMIN_DOCU_CATIGORIES_ROUTE);
        }

        $this->catigoryService->save(
            $catigory
                ->setName($name)
                ->setDescription($description)
        );

        $this->addFlash('success', 'Changes has been saved.');

        return $this->redirectToRoute(self::ADMIN_DOCU_CATIGORIES_ROUTE);
    }
}
