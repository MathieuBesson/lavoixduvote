<?php

namespace App\Repository;

use App\Entity\FaqTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FaqTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaqTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaqTheme[]    findAll()
 * @method FaqTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaqThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaqTheme::class);
    }

    // /**
    //  * @return FaqTheme[] Returns an array of FaqTheme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FaqTheme
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
