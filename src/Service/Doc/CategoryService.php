<?php

declare(strict_types=1);

namespace App\Service\Doc;

use App\Entity\Doc\Category;
use App\Repository\Doc\CategoryRepository;
use DateTime;

final readonly class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
    }

    public function getById(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

    public function getOneByName(string $name): ?Category
    {
        return $this->categoryRepository->findOneBy(['name' => $name]);
    }

    public function getFirstOne(): ?Category
    {
        return $this->categoryRepository->findOneBy([], ['createdAt' => 'DESC']);
    }

    public function getAll(): array
    {
        return $this->categoryRepository->findBy([], ['id' => 'DESC']);
    }

    public function save(Category $category): Category
    {
        $this->categoryRepository->save($category->setUpdatedAt(new DateTime()), true);

        return $category;
    }

    public function search(string $keyword): array
    {
        return $this->categoryRepository->search($keyword);
    }
}
