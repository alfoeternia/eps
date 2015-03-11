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
        $qb->expr()->like('u.roles', '?1'),
        $qb->expr()->like('u.roles', '?2'),
        $qb->expr()->like('u.roles', '?3')))
        ->setParameters(array(
        1 => '%"ROLE_BUREAU"%',
        2 => '%"ROLE_REPORTER"%',
        3 => '%"ROLE_MAJ"%'))
        ->orderBy('u.id', 'DESC');

        return $qb;
    }
}