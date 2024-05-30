<?php

declare(strict_types=1);

namespace App\Service\Docs;

use App\Entity\Docu\DocuCatigory;
use App\Entity\Docu\DocuItem;
use App\Repository\Docu\DocuItemRepository;
use DateTime;

final class ItemService
{
    public function __construct(
        private readonly DocuItemRepository $itemRepository
    ) {
    }

    public function getById(int $id): ?DocuItem
    {
        return $this->itemRepository->find($id);
    }

    public function getFirstOneByCatigory(DocuCatigory $catigory): ?DocuItem
    {
        return $this->itemRepository->findOneBy(['catigory' => $catigory], ['id' => 'ASC']);
    }

    /**
     * @return DocuItem[]
     */
    public function getAll(): array
    {
        return $this->itemRepository->findBy([], ['id' => 'DESC']);
    }

    /**
     * @return DocuItem[]
     */
    public function getAllByCatigory(DocuCatigory $catigory): array
    {
        return $this->itemRepository->findBy(['catigory' => $catigory], ['id' => 'ASC']);
    }

    public function getOneBySlug(string $slug): ?DocuItem
    {
        return $this->itemRepository->findOneBy(['slug' => $slug]);
    }

    public function save(DocuItem $catigory): DocuItem
    {
        $this->itemRepository->save($catigory->setUpdatedAt(new DateTime()), true);

        return $catigory;
    }
}
