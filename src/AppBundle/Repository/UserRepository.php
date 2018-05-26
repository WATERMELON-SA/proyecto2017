<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository{

	public function activeUsersNumber(){
		$query = $this->createQueryBuilder('user')
    		->select('count(user.id)')
    		->where('user.deleted = :deleted')
    		->setParameter('deleted', false)
    		->getQuery();
	    return $query->setMaxResults(1)->getOneOrNullResult();
	}

	public function getUsers($cantPags,$busqueda,$activo,$pagactual=1,$username){
		$inicio=((int)$pagactual-1)*$cantPags;
		if (($busqueda!='') or ($activo!='')) {
			$query = $this->createQueryBuilder('user u')
    		->where("u.active=:activo and u.deleted= :deleted and u.username!= :username and (u.username LIKE :busqueda OR u.name LIKE :busqueda OR u.surname LIKE :busqueda OR u.email LIKE :busqueda)")
    		->setParameter('activo', $activo)
    		->setParameter('deleted', false)
    		->setParameter('username', $username) 
    		->setParameter('busqueda', '%$busqueda%')
    		->setFirstResult($inicio)
    		->setMaxResults($cantPags)
    		->getQuery();
		}
		else{
			$query = $this->createQueryBuilder('user')
    		->where("user.deleted= :deleted and user.username!= :username")
    		->setParameter('deleted', false)
    		->setParameter('username', $username)
    		->setFirstResult($inicio)
    		->setMaxResults($cantPags)
    		->getQuery();
		}
		$usuarios=$query->getResult();
		return $usuarios;
	}

}
