<?php  
	
	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use AppBundle\Entity\Pacient;
	use AppBundle\Entity\ApiReferencia;


class PatientsController extends DefaultController implements MaintenanceController{

// Este metodo se ejecuta cuando se hace un GET a /patient
	
	public function indexAction(Request $request){
		$busqueda=$request->get('busqueda');
		$numero=$request->get('numero');
		$page=$request->get('page')? $request->get('page') : 1;

		$repository = $this->getDoctrine()->getRepository(Pacient::class);
		$pags=ceil(($repository->activePatientsNumber()[1])/($this->site_config()->getElementosPagina()));
		$patients=$this->getPatients($this->site_config()->getElementosPagina(),$busqueda,$numero,$page	);
		return $this->render('patients/patientsModule.html',array("pags"=>$pags,"patients"=>$patients,"numero"=>$numero,"busqueda"=>$busqueda));
	}

	public function destroyAction(Request $request){
		$dni=$request->get('dni');
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(Pacient::class);
		$patient = $repository->findOneByDniNumber($dni);
		$patient->setDeleted(1);
		$manager->flush();
		$resultado='El paciente fue eliminado';
		$pags=ceil(($repository->activePatientsNumber()[1])/($this->site_config()->getElementosPagina()));
		$patients=$this->getPatients($this->site_config()->getElementosPagina(),'','',1);
		return $this->render('patients/patientsModule.html',array("resultado"=>$resultado,"pags"=>$pags,"patients"=>$patients));
	}

	public function addAction(Request $request){
		//$tiposDocumento= ApiReferencia::documentType();
		//$obraSocial=ApiReferencia::obraSocial();
		//$referencias=array('tipoDocumento' =>$tiposDocumento,'obraSocial' =>$obraSocial );
		return $this->render('patients/patientadd.html',array());
	}

	public function insertAction(Request $request){
		$dni=$request->get('dni');
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(Pacient::class);
		$patient = $repository->findOneByDniNumber($dni);
		if (!$patient){
			$patient=new Pacient(); 
			$patient->setName($request->get('name'));
			$patient->setSurname($request->get('lastname'));
			$patient->setAddress($request->get('address'));
			$phone= ($request->get('phone'))? $request->get('phone') : null;
			$patient->setPhone($phone);
			$patient->setBirthDate(new \DateTime($request->get('birthday')));
			$patient->setGender($request->get('genre'));
			$patient->setDniNumber($dni);
			$obra_social= ($request->get('obra_social'))? $request->get('obra_social') : null;
			$patient->setIdObraSocial($obra_social);
			$patient->setIdTipoDoc($request->get('dni_type'));
			$patient->setDeleted(0);
			$manager->persist($patient);
			$manager->flush();
			$resultado='El paciente fue agregado correctamente';
		}
		else{
			if ($patient->getDeleted()){
				$patient=setDeleted(0);
				$manager->flush();
				$resultado="El paciente ya existia y se reactivo(se mantienen los datos viejos)";
			}
			else{
				$resultado="El paciente exite y esta activo";
			}
		}
		$pags=ceil(($repository->activePatientsNumber()[1])/($this->site_config()->getElementosPagina()));
		$patients=$this->getPatients($this->site_config()->getElementosPagina(),'','',1);
		return $this->render('patients/patientsModule.html',array("resultado"=>$resultado,"pags"=>$pags,"patients"=>$patients)); 
	}

	public function updateAction(Request $request){
		$repository = $this->getDoctrine()->getRepository(Pacient::class);
		$patient = $repository->findOneByDniNumber($request->get('dni'));
		$patient->setBirthDate($patient->getBirthDate()->format('d-m-Y'));
		return $this->render('patients/patientadd.html',array('paciente'=>$patient));

	}

	public function update_queryAction(Request $request){
		$dni=$request->get('dni');
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(Pacient::class);
		$patient = $repository->findOneByDniNumber($dni);
		$patient->setName($request->get('name'));
		$patient->setSurname($request->get('lastname'));
		$patient->setAddress($request->get('address'));
		$phone= ($request->get('phone'))? $request->get('phone') : null;
		$patient->setPhone($phone);
		$patient->setBirthDate(new \DateTime($request->get('birthday')));
		$patient->setGender($request->get('genre'));
		$patient->setDniNumber($dni);
		$obra_social= ($request->get('obra_social'))? $request->get('obra_social') : null;
		$patient->setIdObraSocial($obra_social);
		$patient->setDeleted(0);
		$manager->flush();

		$resultado='El paciente fue actualizado';
		$pags=ceil(($repository->activePatientsNumber()[1])/($this->site_config()->getElementosPagina()));
		$patients=$this->getPatients($this->site_config()->getElementosPagina(),'','',1);
		return $this->render('patients/patientsModule.html',array("resultado"=>$resultado,"pags"=>$pags,"patients"=>$patients)); 
	}


	private function getPatients($cantPags,$busqueda,$numero,$pagactual=1){	
			$repository = $this->getDoctrine()->getRepository(Pacient::class);
			$patients=$repository->getPatients($cantPags,$busqueda,$numero,$pagactual);
			if (!$patients)
				return "no hay pacientes";
			else return $patients;
	}
	
	private function buildGraphicHasHasnt($array){

			$total=$array[0]+$array[1];
			$porcentajePosee=($array[1]*100)/$total;
			$porcentajeNoPosee=100-$porcentajePosee;
			$grafico=array(['name'=>'Posee','y'=>$porcentajePosee],['name'=>'No posee','y'=>$porcentajeNoPosee]);
			return json_encode($grafico);
		}

	private function buildGraphicLotOf($array,$tipo){
		$total = 0;
		foreach ($array as $key => $value) {
			$total+=$value;
		}
		$arreglo = [];
		foreach ($array as $key => $value) {
			if ($tipo == 'agua') {
				$arreglo[] = ['name'=>ReferenciasController::getInstance()->tipoAgua((int)$key)->name(),'y'=>($value*100)/$total];
			}elseif ($tipo == 'vivienda') {
				$arreglo[] = ['name'=>ReferenciasController::getInstance()->tipoVivienda((int)$key)->name(),'y'=>($value*100)/$total];
			}else{
				$arreglo[] = ['name'=>ReferenciasController::getInstance()->tipoCalefaccion((int)$key)->name(),'y'=>($value*100)/$total];
			}

		}
		return json_encode($arreglo);
	}
}
?>