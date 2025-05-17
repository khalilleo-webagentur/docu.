<?php

namespace App\Controller\Doc;

use App\Service\Doc\CategoryService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    use FormValidationTrait;

    private const DOC_HOME = 'app_doc_home';

    public function __construct(
        private readonly CategoryService $categoryService
    ){
    }

    #[Route('/g2p0n2x3/q', name: 'app_doc_search_q', methods: 'POST')]
    public function search(Request $request): Response
    {
        $keyword = $this->validate($request->request->get('q'));

        if (!$keyword) {
            return $this->redirectToRoute(self::DOC_HOME);
        }

        $categories = $this->categoryService->search($keyword);

        return $this->render('doc/search.html.twig', [
            'categories' => $categories,
            'keyword' => $keyword
        ]);
    }
}
