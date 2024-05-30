<?php

namespace App\Repository\Docu;

use App\Entity\Docu\DocuCatigory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocuCatigory>
 */
class DocuCatigoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocuCatigory::class);
    }

    public function save(DocuCatigory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DocuCatigory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return DocuCatigory[] Returns an array of DocuCatigory objects
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
