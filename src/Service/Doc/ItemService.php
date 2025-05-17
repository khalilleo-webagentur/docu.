<?php

declare(strict_types=1);

namespace App\Service\Doc;

use App\Entity\Doc\Category;
use App\Entity\Doc\Item;
use App\Repository\Doc\ItemRepository;
use DateTime;

final readonly class ItemService
{
    public function __construct(
        private ItemRepository $itemRepository
    ){
    }

    public function getById(int $id): ?Item
    {
        return $this->itemRepository->find($id);
    }

    public function getFirstOneByCategory(Category $category): ?Item
    {
        return $this->itemRepository->findOneBy(['category' => $category], ['id' => 'ASC']);
    }

    /**
     * @return Item[]
     */
    public function getAll(): array
    {
        return $this->itemRepository->findBy([], ['id' => 'DESC']);
    }

    /**
     * @return Item[]
     */
    public function getAllByCategory(Category $category): array
    {
        return $this->itemRepository->findBy(['category' => $category], ['id' => 'ASC']);
    }

    public function getOneBySlug(string $slug): ?Item
    {
        return $this->itemRepository->findOneBy(['slug' => $slug]);
    }

    public function save(Item $category): Item
    {
        $this->itemRepository->save($category->setUpdatedAt(new DateTime()), true);

        return $category;
    }
}
