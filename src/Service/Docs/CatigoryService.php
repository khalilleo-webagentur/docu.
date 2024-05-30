<?php

declare(strict_types=1);

namespace App\Service\Docs;

use App\Entity\Docu\DocuCatigory;
use App\Repository\Docu\DocuCatigoryRepository;
use DateTime;

final class CatigoryService
{
    public function __construct(
        private readonly DocuCatigoryRepository $catigoryRepository
    ) {
    }

    public function getById(int $id): ?DocuCatigory
    {
        return $this->catigoryRepository->find($id);
    }

    public function getOneByName(string $name): ?DocuCatigory
    {
        return $this->catigoryRepository->findOneBy(['name' => $name]);
    }

    public function getFirstOne(): ?DocuCatigory
    {
        return $this->catigoryRepository->findOneBy([], ['createdAt' => 'DESC']);
    }

    public function getAll(): array
    {
        return $this->catigoryRepository->findBy([], ['id' => 'DESC']);
    }

    public function save(DocuCatigory $catigory): DocuCatigory
    {
        $this->catigoryRepository->save($catigory->setUpdatedAt(new DateTime()), true);

        return $catigory;
    }

    public function search(string $keyword): array
    {
        return $this->catigoryRepository->search($keyword);
    }
}
