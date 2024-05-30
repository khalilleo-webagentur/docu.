<?php

namespace App\Controller\Docu;

use App\Service\Docs\CatigoryService;
use App\Traits\FormValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    use FormValidationTrait;

    private const DOCU_HOME = 'app_docu_home';

    public function __construct(
        private readonly CatigoryService $catigoryService
    ) {
    }

    #[Route('/g2p0n2x3/q', name: 'app_docu_search_q', methods: 'POST')]
    public function search(Request $request): Response
    {
        $keyword = $this->validate($request->request->get('q'));

        if (!$keyword) {
            return $this->redirectToRoute(self::DOCU_HOME);
        }

        $catigories = $this->catigoryService->search($keyword);

        return $this->render('docu/search.html.twig', [
            'catigories' => $catigories,
            'keyword' => $keyword
        ]);
    }
}
