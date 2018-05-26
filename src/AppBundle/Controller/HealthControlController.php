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
        $array=array("patient"=>$patient,"controles"=>$controles);
        $array=array_merge($array,$this->mostrarGraficos($controles,$patient->getGender()));
        return $this->render('historia_clinica/historiaClinica.html', $array);
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

        //Chequea si los campos son validos
        $validator = $this->get('validator');
        $errors = $validator->validate($control);
        if (count($errors) > 0) {
            return $this->render('historia_clinica/control_salud.html', array('patient_dni'=>$patient_dni,'errors'=>$errors));

        }

        $manager->persist($control);
        $manager->flush();

        return $this->indexAction($request);

        
    }

     public function updateAction(Request $request){
        $patient_dni=$request->get('patient_dni');
        $control_id=$request->get('id');
        $manager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(ControlSalud::class);
        $control=$repository->findOneById($control_id);
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
        $control->setUsuario($this->getUser());

        $validator = $this->get('validator');
        $errors = $validator->validate($control);
        if (count($errors) > 0) {
            return $this->render('historia_clinica/control_salud.html', array('patient_dni'=>$patient_dni,'errors'=>$errors,'control'=>$control));

        }

        $manager->flush();

        return $this->render('historia_clinica/control_salud.html', array("patient_dni"=>$patient_dni,'control'=>$control,'update'=>true));
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

    public function mostrarGraficos($controles,$hombre){
        $pesos= json_encode($this->getPesosAsArray($controles));
        $ppcs= json_encode($this->getPPCAsArray($controles));
        $tallas= json_encode($this->getTallasAsArray($controles));
        return array('patient_cc' =>$pesos,'patient_ct' => $tallas, 'patient_cpc' => $ppcs, "hombre" => $hombre);
    }

    public function helperPesos($controles){
        $x= 0;
        $array=array( );
        foreach ($controles as $key) {
            $array[]=[$x,(int)$key->getPeso()];
            $x++;
        }
        return $array;
    }

     public function helperPPC($controles){
        $x= 0;
        $array=array( );
        foreach ($controles as $key) {
            $array[]=[$x,(int)$key->getPpc()];
            $x++;
        }
        return $array;
    }

    public function getPesosAsArray($controles){
        return $this->helperPesos($controles);
    }

    public function getPPCAsArray($controles){
        return $this->helperPPC($controles);
    }

    public function getTallasAsArray($controles){
        $x= 0;
        $array=array();
        foreach ($controles as $key) {
            $array[]=[(int)$key->getTalla(),(int)$key->getPeso()];
            $x++;
        }
        return $array;
    }



}
