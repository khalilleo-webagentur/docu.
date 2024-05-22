<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Docu\Catigory;
use App\Repository\Docu\CatigoryRepository;

final class CatigoryService
{
    public function __construct(
        private readonly CatigoryRepository $catigoryRepository
    ) {
    }

    public function getById(int $id): ?Catigory
    {
        return $this->catigoryRepository->find($id);
    }
}
