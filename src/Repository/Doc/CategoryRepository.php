<?php

namespace App\Repository\Doc;

use App\Entity\Doc\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Category[] Returns an array of Category objects
     */
    public function search(string $keyword): array
    {
        $text = '%' . $keyword . '%';
        $qb = $this->createQueryBuilder('t1');
        $qb
            ->where($qb->expr()->like('t1.name', ':name'))
            ->setParameter('name', $text);

        return $qb->orWhere($qb->expr()->like('t1.description', ':description'))
            ->setParameter('description', $text)
            ->setMaxResults(7)
            ->getQuery()
            ->getResult();
    }
}
