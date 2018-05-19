<?php

	namespace AppBundle\Repository\Api;

	use \DateTime;
	use AppBundle\Entity\Api\Turn;

class TurnRepository extends \Doctrine\ORM\EntityRepository{
	
	public function turnsForDate($fecha){
      $fechaexp = explode('-',$fecha);
		if ((DateTime::createFromFormat('Y-m-d', $fecha) != FALSE) && ($fecha>date('Y-m-d')) && ($fechaexp[1]<=12) && ($fechaexp[2]<=31)){
			$turnosReservados = $this->getTurns($fecha);
			$hora=8;
			$min=0;
			$turnosDisponibles=array();
			for($i=0; $i<=23; $i++){
				$elem = $hora . ':' . $min;
				if($this->isAvailable($turnosReservados, $elem)){
					array_push($turnosDisponibles,$elem);
				}
				if($min!=30){
					$min+=30;
				}else{
					$hora+=1;
					$min=0;
				}
			}
		}
		else{
			$turnosDisponibles="No es una fecha valida";
		}
		return $turnosDisponibles;
	}

	private function getTurns($fecha){
      return $this->findBy(array('turnDate' => DateTime::createFromFormat('Y-m-d', $fecha)));
	}

	public function setTurn($dni, $fecha, $hora){
	    $fechaexp = explode('-',$fecha);
		if ((DateTime::createFromFormat('Y-m-d', $fecha) != FALSE) && $fecha>date('Y-m-d') && ($fecha>date('Y-m-d')) && ($fechaexp[1]<=12) && ($fechaexp[2]<=31)){
			$horaAux= explode(":", $hora);
			$minutos= $horaAux[1];
			$hora= $horaAux[0];
			$dni=(int)$dni;
			$horaTotal=$hora.":".$minutos;
			$turnosReservados = $this->getTurns($fecha);
			if ($this->isAvailable($turnosReservados, $horaTotal)) {
				if (( ($hora >= 8) && ($hora < 20)) && (($minutos==0) || ($minutos==30))) {
					$turno = new Turn(DateTime::createFromFormat('Y-m-d', $fecha), $hora, $minutos, $dni);
					$manager = $this->getEntityManager();
					$manager->persist($turno);
					$manager->flush();
					if ($manager->getUnitOfWork()->getEntityState($turno))
						return ("Tu turno ha sido reservado para el $fecha a las $hora:$minutos" );
					else return "Hubo un error, su turno no pudo ser reservado, intente nuevamente";
				}
				else return "La hora ingresada no es valida";	
			}
			return "El turno no esta disponible, por favor elija otro";
		}
		else{
			return "Fecha no valida";
		}
	}

	private function isAvailable($turnosReservados, $hora){
		return !in_array($hora,$this->hoursReserved($turnosReservados),true);
	}

	private function hoursReserved($turnosReservados){
		$reservados = [];
		foreach ($turnosReservados as $key => $turn){
			array_push($reservados,$turn->getHour().":".$turn->getMinutes());
		}
		return $reservados;
	}
}
