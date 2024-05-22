<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Docu\Item;
use App\Repository\Docu\ItemRepository;

final class ItemService
{
    public function __construct(
        private readonly ItemRepository $itemRepository
    ) {
    }

    public function getById(int $id): ?Item
    {
        return $this->itemRepository->find($id);
    }
}
