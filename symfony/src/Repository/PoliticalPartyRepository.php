<?php

namespace App\Repository;

use App\Entity\PoliticalParty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PoliticalParty|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoliticalParty|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoliticalParty[]    findAll()
 * @method PoliticalParty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliticalPartyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PoliticalParty::class);
    }

    // /**
    //  * @return PoliticalParty[] Returns an array of PoliticalParty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PoliticalParty
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
