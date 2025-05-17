<?php

namespace App\Controller\Doc;

use App\Service\Doc\CategoryService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ExportController extends AbstractController
{
    use FormValidationTrait;

    private const DOC_HOME = 'app_doc_home';

    public function __construct(
        private readonly CategoryService $categoryService
    ) {
    }

    #[Route('doc/m3pun6y9/export', name: 'app_doc_export_item_as_pdf')]
    public function exportAsPDF(Request $request): RedirectResponse
    {
        $this->addFlash('notice', 'This feature is not implemented yet!');

        return $this->redirectToRoute(self::DOC_HOME);
    }
}
