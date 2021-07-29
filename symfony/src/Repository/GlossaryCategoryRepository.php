<?php

namespace App\Repository;

use App\Entity\GlossaryCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GlossaryCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method GlossaryCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method GlossaryCategory[]    findAll()
 * @method GlossaryCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GlossaryCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GlossaryCategory::class);
    }

    // /**
    //  * @return GlossaryCategory[] Returns an array of GlossaryCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GlossaryCategory
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
