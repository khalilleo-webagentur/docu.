<?php

namespace App\Controller\Docu;

use App\Service\Docs\CatigoryService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ExportController extends AbstractController
{
    use FormValidationTrait;

    private const DOCU_HOME = 'app_docu_home';

    public function __construct(
        private readonly CatigoryService $catigoryService
    ) {
    }

    #[Route('docu/m3pun6y9/export', name: 'app_docu_export_item_as_pdf')]
    public function exportAsPDF(Request $request): RedirectResponse
    {
        $this->addFlash('notice', 'This feature is not implmented yet!');

        return $this->redirectToRoute(self::DOCU_HOME);
    }
}
