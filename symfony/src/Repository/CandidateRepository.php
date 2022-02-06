<?php

namespace App\Repository;

use App\Entity\Candidate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

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

    /**
     * Get program of a candidate, grouped by themes and order by importance of action
     *
     * @param int $candidateId
     * @return array
     */
    public function getProgramByThemes(int $candidateId): array
    {
        $scalarResult = $this->createQueryBuilder('c')
            ->select('c')
            ->addSelect('p')
            ->addSelect('a')
            ->addSelect('t')
            ->innerJoin('c.program', 'p')
            ->innerJoin('p.actions', 'a')
            ->innerJoin('a.theme', 't')
            ->where('c.id = :id',)
            ->orderBy('a.title', 'ASC')
            ->setParameter('id', $candidateId)
            ->getQuery()
            ->getScalarResult();

        $measuresByThemes = [];
        foreach ($scalarResult as $result) {
            if (!isset($measuresByThemes[$result['t_label']])) {
                $measuresByThemes[$result['t_label']] = [];
            }
            $measuresByThemes[$result['t_label']][$result['a_id']]['title'] = $result['a_title'];
        }

        return $measuresByThemes;
    }

    /**
     * Get all candidates from a specific primary
     *
     * @param $primaryId
     * @return int|mixed|string
     */
    public function getCandidatesByPrimaries($primaryId)
    {
        return $this->createQueryBuilder('c')
            ->join('c.partyPrimary', 'p')
            ->select('c')
            ->addSelect('p')
            ->where('p.id = :primaryId')
            ->setParameter('primaryId', $primaryId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get all candidates to the presidential, aka that had been elected to the primary
     *
     * @return int|mixed|string
     */
    public function getPresidentialCandidates()
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.electedByPrimary = true')
            ->getQuery()
            ->getResult();
    }

	/**
	 * Get all candidates to the presidential, aka that had been elected to the primary
	 *
	 * @return int|mixed|string
	 */
	public function getPresidentialCandidatesWithProgram()
	{
		$qb = $this->createQueryBuilder('c');
		return $qb
		            ->select('c')
					->innerJoin('c.program', 'pr')
					->innerJoin('pr.actions', 'ac')
		            ->where('c.electedByPrimary = true')
		            ->getQuery()
		            ->getResult();
	}

    public function findAllNames()
    {
        return $this->createQueryBuilder('candidates')
            ->select(['candidates.firstName', 'candidates.lastName'])
            ->getQuery()
            ->getResult();
    }


    public function getAllWithProgramPartyActionsAndTheme(): array
    {
        $scalarResult = $this->createQueryBuilder('c')
            ->select('c')
            ->addSelect('pr')
            ->addSelect('po')
            ->addSelect('a')
            ->addSelect('t')
            ->innerJoin('c.program', 'pr')
            ->innerJoin('c.politicalParty', 'po')
            ->innerJoin('pr.actions', 'a')
            ->innerJoin('a.theme', 't')
            ->orderBy('a.title', 'ASC')
            ->getQuery()
            ->getScalarResult();

        $measuresByThemes = [];
        foreach ($scalarResult as $result) {
            if (!isset($measuresByThemes[$result['t_label']])) {
                $measuresByThemes[$result['t_label']] = [];
            }
            $measuresByThemes[$result['t_label']][$result['c_id']]['actions'][] = $result['a_title'];
            $measuresByThemes[$result['t_label']][$result['c_id']]['name'] = $result['c_firstName'] . ' ' . $result['c_lastName'];
            $measuresByThemes[$result['t_label']][$result['c_id']]['politicalParty'] = $result['po_name'];
        }
        
        return $measuresByThemes;
    }
}
