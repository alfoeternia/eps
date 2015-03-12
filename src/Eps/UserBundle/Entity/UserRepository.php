<?php

namespace Eps\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
	public function findReporters()
	{
		/*$qb = $this->createQueryBuilder('u');
		$qb->select('DISTINCT u.pseudo AS pseudo')->where('u.role CONTAINS("ROLE_USER")');

		$results = $qb->getQuery()->getResult();
		$years = array();
		if($results != NULL)
			foreach($results as $result)
				$years[] = $result['years'];
		return $years;*/
	}

	public function getReporters ()
    {

        $qb = $this->createQueryBuilder('u');
        $qb->where($qb->expr()->orX(
        $qb->expr()->eq('u.rank', '?1'),
        $qb->expr()->eq('u.rank', '?2'),
        $qb->expr()->eq('u.rank', '?3'),
        $qb->expr()->eq('u.rank', '?5'),
        $qb->expr()->eq('u.rank', '?6')))
        ->setParameters(array(
        1 => 'TREASURER',
        2 => 'GODFATHER',
        3 => 'REPORTER',
        5 => 'PRESIDENT',
        6 => 'SECRETARY'))
        ->orderBy('u.id', 'DESC');

        return $qb;

    }
}