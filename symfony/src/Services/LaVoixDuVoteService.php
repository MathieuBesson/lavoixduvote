<?php

namespace App\Services;

use App\Entity\Primary;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Basic queries and information on the application
 */
class LaVoixDuVoteService
{
	private EntityManagerInterface $em;

	public function __construct(EntityManagerInterface $em) {
		$this->em = $em;
	}

	public function isThereAnyPrimaryChoice()
	{
		$primaries = $this->em
		                  ->getRepository(Primary::class)
		                  ->getCurrentPrimaries();
		return !(count($primaries) === 0);
	}
}
