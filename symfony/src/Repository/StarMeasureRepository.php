<?php

namespace App\Repository;

use App\Entity\StarMeasure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StarMeasure|null find($id, $lockMode = null, $lockVersion = null)
 * @method StarMeasure|null findOneBy(array $criteria, array $orderBy = null)
 * @method StarMeasure[]    findAll()
 * @method StarMeasure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StarMeasureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StarMeasure::class);
    }

    // /**
    //  * @return StarMeasure[] Returns an array of StarMeasure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StarMeasure
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
