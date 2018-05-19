<?php  
	
	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use AppBundle\Entity\Site;


class SiteController extends DefaultController{

// Este metodo se ejecuta cuando se hace un GET a /config

	public function indexAction(Request $request){
		return $this->render(
			'general/configuracion_sitio.html',
			array('sitio' => $this->site_config()
		));
	}

// Este metodo se ejecuta cuando se hace un PUT a /config

	public function updateAction(Request $request){
		$this->update_values($request);
		return $this
			->render('general/configuracion_sitio.html',
					array('sitio' => $this->site_config(), 
					"update" => "cambios"));
	}

// Este metodo visualiza la pagina "Sobre el hospital"

	public function infoHospitalAction(){
		return $this->render(
			'general/infoHospital.html',
			array('sitio' => $this->site_config()
		));
	}

// Este metodo actualiza los datos del sitio

	private function update_values($request){
		$manager = $this->getDoctrine()->getManager();
		$site_to_update = $this->site_config();
		$site_to_update->setTitulo(
			$request->get('titulo')
		);
		$site_to_update->setDescripcion(
			$request->get('descripcion')
		);
		$site_to_update->setEmail(
			$request->get('email')
		);
		$site_to_update->setElementosPagina(
			$request->get('elementos_pagina')
		);
		$site_to_update->setSitioHabilitado(
			$request->get('sitio_habilitado')
		);

		$manager->flush();
	}
}
?>