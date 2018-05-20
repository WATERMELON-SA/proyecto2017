<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Pacient;
use AppBundle\Entity\ControlSalud;

class HealthControlController extends DefaultController{

    public function showAction(Request $request){   
        $patient_dni=$request->get('patient_dni');
        $control_id=$request->get('control_id');
        $repository = $this->getDoctrine()->getRepository(ControlSalud::class);
        $patient_repository = $this->getDoctrine()->getRepository(Pacient::class);

        $control=$repository->findOneById($control_id);
        $patient=$patient_repository->findByDniNumber($patient_dni);
        return $this->render('historia_clinica/control_salud.html', array("patient_dni"=>$patient_dni,'control'=>$control));
    }

    public function indexAction(Request $request){   
        $patient_dni=$request->get('patient_dni');
        $patient_repository = $this->getDoctrine()->getRepository(Pacient::class);
        $repository = $this->getDoctrine()->getRepository(ControlSalud::class);
        $patient=$patient_repository->findOneByDniNumber($patient_dni);
        $controles=$repository->findByPaciente($patient);
        $controles=array_filter($controles,function($control){return $control->getEliminado()==0;});
        return $this->render('historia_clinica/historiaClinica.html', array("patient"=>$patient,"controles"=>$controles));
    }

    public function addAction(Request $request){
        $patient_dni=$request->get('patient_dni');
        return $this->render('historia_clinica/control_salud.html', array('patient_dni'=>$patient_dni));
    }

    public function insertAction(Request $request){
        $patient_dni=$request->get('patient_dni');
        $manager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(ControlSalud::class);
        $patient_repository = $this->getDoctrine()->getRepository(Pacient::class);
        $patient=$patient_repository->findOneByDniNumber($patient_dni);

        $control=new ControlSalud();
        $control->setFecha(new \DateTime($request->get('fecha')));
        $control->setPeso($request->get('peso'));
        $control->setVacunasCompletas($request->get('vacunas_completas'));
        $control->setMaduracionAcorde($request->get('maduracion_acorde'));
        $control->setExFisicoNormal($request->get('ex_fisico_normal'));
        $control->setExFisicoObservaciones($request->get('ex_fisico_observaciones'));
        $control->setPpc($request->get('ppc'));
        $control->setPc($request->get('pc'));
        $control->setTalla($request->get('talla'));
        $control->setAlimentacion($request->get('alimentacion'));
        $control->setObservacionesGenerales($request->get('observaciones_generales'));
        $control->setEliminado(0);
        $control->setUsuario($this->getUser());
        $control->setPaciente($patient);
        $control->setEdad(((new \DateTime('today'))->diff($patient->getBirthDate()))->y);

        $manager->persist($control);
        $manager->flush();

        return $this->indexAction($request);

        
    }

     public function updateAction(Request $request){

        return $this->render('historia_clinica/control_salud.html', array());
    }

     public function destroyAction(Request $request){
        $control_id=$request->get('control_id');
        $patient_dni=$request->get('patient_dni');
        $manager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(ControlSalud::class);
        $user = $repository->findOneById($control_id);
        $user->setEliminado(1);
        $manager->flush();

        return $this->indexAction($request);
    }

    public function mostrarGraficos($dni,$hombre){
        $controles=$repository->findById_paciente($patient->getId());
        $controles=array_filter($controles,function($control){return $control->getEliminado()==0;});
        $pesos= json_encode($this->getPesosAsArray($controles));
        $ppcs= json_encode($this->getPPCAsArray($controles));
        $tallas= json_encode($this->getTallasAsArray($controles));
        return array('patient_cc' =>$pesos,'patient_ct' => $tallas, 'patient_cpc' => $ppcs, "hombre" => $hombre);        
    }

    public function helper($atributo, $controles){
        $x= 0;
        $array=array( );
        foreach ($controles as $key) {
            $array[]=[$x,(int)$key[$atributo]];
            $x++;
        }
        return $array;
    }

    public function getPesosAsArray($controles){
        return $this->helper('peso',$controles);
    }

    public function getPPCAsArray($controles){
        return $this->helper('ppc',$controles);
    }

    public function getTallasAsArray($controles){
        $x= 0;
        $array=array();
        foreach ($controles as $key) {
            $array[]=[(int)$key['talla'],(int)$key['peso']];
            $x++;
        }
        return $array;
    }



}
