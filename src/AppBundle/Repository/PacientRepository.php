<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query;


class PacientRepository extends \Doctrine\ORM\EntityRepository{

	public function activePatientsNumber($busqueda='',$numero=''){
		$query = $this->createQueryBuilder('patient')
    		->select('count(patient.id)')
    		->where('patient.deleted= :deleted')
    		->setParameter('deleted', false);
    	if ($busqueda!='') {
			$query = 
				$query
		    		->andWhere("patient.name LIKE :busqueda OR patient.surname LIKE :busqueda")
		    		->setParameter('busqueda', "%$busqueda%");
		}
		if ($numero!='') {
			$query = 
				$query
		    		->andWhere("patient.dniNumber= :numero")
		    		->setParameter('numero', (int) $numero);
		}

	    return $query->getQuery()->setMaxResults(1)->getOneOrNullResult();
	}

	public function getPatients($cantPags,$busqueda,$numero,$pagactual=1){
		$elem=$cantPags;
		$inicio=($pagactual-1)*$elem;
		
		$query = 
			$this->createQueryBuilder('patient')
			->where("patient.deleted= :deleted")
    		->setParameter('deleted', false);
		
		if ($busqueda!='') {
			$query = 
				$query
		    		->andWhere("patient.name LIKE :busqueda OR patient.surname LIKE :busqueda")
		    		->setParameter('busqueda', "%$busqueda%");
		}
		if ($numero!='') {
			$query = 
				$query
		    		->andWhere("patient.dniNumber= :numero")
		    		->setParameter('numero', (int) $numero);
		}
		
		return $query 
		->orderBy('patient.surname')
		->setFirstResult($inicio)
		->setMaxResults($elem)
		->getQuery()
		->getResult();
	}

}
