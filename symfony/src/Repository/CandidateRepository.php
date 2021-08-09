<?php

namespace App\Repository;

use App\Entity\Candidate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Candidate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidate[]    findAll()
 * @method Candidate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidate::class);
    }

    /**
     * Returns the candidate whom last name match the parameter in
     * a case insentitive way
     *
     * @param $lastName
     * @return Candidate|null
     */
    public function findOneByLastNameCaseInsensitive($lastName): ?Candidate
    {
        $result = $this->createQueryBuilder('a')
            ->where('upper(a.lastName) = upper(:lastName)')
            ->setParameter('lastName', $lastName)
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();
        return array_shift($result);
    }

    public function findAllNames()
    {
        return $this->createQueryBuilder('candidates')
            ->select(['candidates.firstName', 'candidates.lastName'])
            ->getQuery()
            ->getResult();
    }
}
