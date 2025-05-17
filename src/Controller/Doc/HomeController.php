<?php

namespace App\Controller\Doc;

use App\Service\Doc\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {
    }

    #[Route('/', name: 'app_doc_home')]
    public function index(): Response
    {
        $categories = $this->categoryService->getAll();

        return $this->render('index.html.twig', [
            'categories' => $categories
        ]);
    }
}
