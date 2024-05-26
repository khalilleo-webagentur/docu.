<?php

declare(strict_types=1);

namespace App\Service\Docs;

use App\Entity\Docu\Catigory;
use App\Repository\Docu\CatigoryRepository;
use DateTime;

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

    public function getOneByName(string $name): ?Catigory
    {
        return $this->catigoryRepository->findOneBy(['name' => $name]);
    }

    public function getFirstOne(): ?Catigory
    {
        return $this->catigoryRepository->findOneBy([], ['createdAt' => 'DESC']);
    }

    public function getAll(): array
    {
        return $this->catigoryRepository->findBy([], ['id' => 'DESC']);
    }

    public function save(Catigory $catigory): Catigory
    {
        $this->catigoryRepository->save($catigory->setUpdatedAt(new DateTime()), true);

        return $catigory;
    }
}
