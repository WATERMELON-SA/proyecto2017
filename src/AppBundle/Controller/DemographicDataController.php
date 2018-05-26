<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\DemographicData;
use AppBundle\Entity\Referencias;
use AppBundle\Entity\Pacient;



class DemographicDataController extends DefaultController implements MaintenanceController{


    public function indexAction(Request $request){
        $dni=$request->get('patient_dni');
        $patient = $this->getDoctrine()->getRepository(Pacient::class)->findBy(array('dniNumber' => $dni))[0];
        $id_datos = $patient->getDemographic();
        $demographic_data=$this->getDoctrine()->getRepository(DemographicData::class)->getDemographicData($id_datos);
        $tipoagua=Referencias::tipoAgua();
        $tipovivienda=Referencias::tipoVivienda();
        $tipocalefaccion=Referencias::tipoCalefaccion();
        $referencias=array('tipoAgua' =>$tipoagua,'tipoCalefaccion' =>$tipocalefaccion,'tipoVivienda'=>$tipovivienda );
        
        if ($demographic_data!=1){
            return $this-> render(
                'general/demographicDataModule.html',
                array("inicio" => true,"tiene_datos"=>true,"patients_data"=>$demographic_data,"referencias"=>$referencias, 'paciente' => $dni)
            );
        }else{
            return $this-> render(
                'general/demographicDataModule.html',
                array("inicio" => true,"tiene_datos"=>false,"patients_data"=>$demographic_data,"paciente"=>$dni)
            );
        }
    }

    public function destroyAction(Request $request){
        $id_datos=$request->get('id_datos');
        $datos = $this->getDoctrine()->getRepository(DemographicData::class)->find($id_datos);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($datos);
        $manager->flush();
        return $this-> render(
            'general/demographicDataModule.html',
            array("inicio" => true,"tiene_datos"=>false)
        );
    }

    public function addAction(Request $request){
        $dni = $request->get('dni');
        $tipoagua=Referencias::tipoAgua();
        $tipovivienda=Referencias::tipoVivienda();
        $tipocalefaccion=Referencias::tipoCalefaccion();
        $referencias=array('tipoAgua' =>$tipoagua,'tipoCalefaccion' =>$tipocalefaccion,'tipoVivienda'=>$tipovivienda );
        return $this->render('general/demographicDataModule.html',array("cargar_datos"=>true,"referencias"=>$referencias,"paciente"=>$dni));
    }

    public function insertAction(Request $request){
        $dni = $request->get('dni_paciente');
        $patient = $this->getDoctrine()->getRepository(Pacient::class)->getPatientByDni($dni)[0];
        $em = $this->getDoctrine()->getManager();
        $datos = new DemographicData();
        $datos->setHeladera($request->get('fridge'));
        $datos->setElectricidad($request->get('electricity'));
        $datos->setMascota($request->get('pets'));
        $datos->setTipoVivienda($request->get('home'));
        $datos->setTipoAgua($request->get('water'));
        $datos->setTipoCalefaccion($request->get('heating'));

        // Chequea si los campos son validos
        $validator = $this->get('validator');
        $errors = $validator->validate($datos);
        if (count($errors) > 0) {
            $tipoagua=Referencias::tipoAgua();
            $tipovivienda=Referencias::tipoVivienda();
            $tipocalefaccion=Referencias::tipoCalefaccion();
            $referencias=array('tipoAgua' =>$tipoagua,'tipoCalefaccion' =>$tipocalefaccion,'tipoVivienda'=>$tipovivienda );
            return $this->render('general/demographicDataModule.html',array("cargar_datos"=>true,"referencias"=>$referencias,"paciente"=>$dni,'errors'=>$errors));
        }

        $em->persist($datos);
        $em->flush();
        $id=$datos->getId();
        $patient->setDemographicData($id);
        $em->flush();
        return $this->redirectToRoute('patients_index');

    
    }

    public function updateAction(Request $request){
        $id_datos=$request->get('id_datos_demo');
        $entityManager = $this->getDoctrine()->getManager();
        $datos = $entityManager->getRepository(DemographicData::class)->find($id_datos);
        $datos->setHeladera($request->get('fridge'));
        $datos->setElectricidad($request->get('electricity'));
        $datos->setMascota($request->get('pets'));
        var_dump($request->get('home'));
        $datos->setTipoVivienda($request->get('home'));
        $datos->setTipoAgua($request->get('water'));
        $datos->setTipoCalefaccion($request->get('heating'));

        // Chequea si los campos son validos
        $validator = $this->get('validator');
        $errors = $validator->validate($datos);
        if (count($errors) > 0) {
            $tipoagua=Referencias::tipoAgua();
            $tipovivienda=Referencias::tipoVivienda();
            $tipocalefaccion=Referencias::tipoCalefaccion();
            $referencias=array('tipoAgua' =>$tipoagua,'tipoCalefaccion' =>$tipocalefaccion,'tipoVivienda'=>$tipovivienda );
            return $this->render('general/demographicDataModule.html',array("cargar_datos"=>true,"referencias"=>$referencias,"paciente"=>$dni,'errors'=>$errors,'patients_data'=>$datos));
        }

        if (!$datos) {
            throw $this->createNotFoundException(
                'No product found for id '.$id_datos
            );
        }
        $entityManager->flush();
        return $this->redirectToRoute('patients_index');
    }


}