<?php  
	
	namespace AppBundle\Controller\Api;
	
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use AppBundle\Entity\Api\Turn;

class TurnController extends Controller{

// Este metodo se ejecuta cuando se hace un GET a /api/turns

	public function indexAction(Request $request){
		$fecha = $request->get('fecha');
		$manager = $this->getDoctrine()->getRepository(Turn::class);
		$turnos = $manager->turnsForDate($fecha);
		
		return new Response(json_encode(array('Turnos disponibles' => $turnos),200));
	}

// Este metodo se ejecuta cuando se hace un POST a /api/turns

	public function updateAction(Request $request){
		$dni = $request->get('dni');
		$fecha= $request->get('fecha');
		$hora= $request->get('hora');
		$manager = $this->getDoctrine()->getRepository(Turn::class);
		$resul= $manager->setTurn($dni, $fecha, $hora);
		return new Response(json_encode($resul,200));
	}
}
?>