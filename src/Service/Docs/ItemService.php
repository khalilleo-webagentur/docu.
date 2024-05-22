<?php

declare(strict_types=1);

namespace App\Service\Docs;

use App\Entity\Docu\Item;
use App\Repository\Docu\ItemRepository;
use DateTime;

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

    public function save(Item $catigory): Item
    {
        $this->itemRepository->save($catigory->setUpdatedAt(new DateTime()), true);

        return $catigory;
    }
}
