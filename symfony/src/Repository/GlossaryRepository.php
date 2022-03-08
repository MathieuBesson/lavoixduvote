<?php

namespace App\Repository;

use App\Entity\Glossary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Glossary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Glossary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Glossary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GlossaryRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Glossary::class);
    }

    /**
     * Glossary comes ordered, always.
     *
     * @return \App\Entity\Glossary[]|array|object[]
     */
    public function findAll()
    {
        return $this->findBy([], ['word' => 'ASC'], NULL);
    }

}
