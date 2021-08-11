<?php

namespace App\Repository;

use App\Entity\Primary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Primary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Primary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Primary[]    findAll()
 * @method Primary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrimaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Primary::class);
    }

    /**
     * Select all primaries that are not over, aka : no elected candidates
     *
     * @return int|mixed|string
     */
    public function getCurrentPrimaries()
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->addSelect('c')
            ->join('p.candidates', 'c')
            ->where('c.electedByPrimary <> true')
            ->getQuery()
            ->getResult();
    }
}
