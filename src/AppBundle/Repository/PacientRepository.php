<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query;


class PacientRepository extends \Doctrine\ORM\EntityRepository{

	public function activePatientsNumber(){
		$query = $this->createQueryBuilder('patient')
    		->select('count(patient.id)')
    		->where('patient.deleted=0')
    		->getQuery();
	    return $query->setMaxResults(1)->getOneOrNullResult();
	}

	public function getPatients($cantPags,$busqueda,$numero,$pagactual=1){
		$elem=$cantPags;
		$inicio=($pagactual-1)*$elem;
		if (($numero!='')&&($busqueda=='')) {
			$query = $this->createQueryBuilder('patient')
    		->where("patient.deleted=0 and patient.dniNumber=$numero AND patient.idTipoDoc=2")
    		->setFirstResult($inicio)
    		->setMaxResults($elem)
    		->getQuery();
		}
		elseif ($busqueda!='') {
			$query = $this->createQueryBuilder('patient')
    		->where("patient.deleted=0 and (patient.name LIKE '%$busqueda%' OR patient.surname LIKE '%$busqueda%')")
    		->setFirstResult($inicio)
    		->setMaxResults($elem)
    		->getQuery();
		}else{
			$query = $this->createQueryBuilder('patient')
    		->where("patient.deleted=0")
    		->setFirstResult($inicio)
    		->setMaxResults($elem)
    		->getQuery();
		}
		$pacientes=$query->getResult();
		return $pacientes;
	}

}
