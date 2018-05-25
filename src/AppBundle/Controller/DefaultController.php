<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Site;
use AppBundle\Controller\MaintenanceController;
use Symfony\Component\HttpFoundation\Response;



class DefaultController extends Controller{

    protected $site = FALSE;
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    
    // Este metodo permite obtener la instancia del sitio actual (singleton).

    public function site_config(){
        if(!$this->site){
            $this->site = $this->getDoctrine() 
            ->getRepository(Site::class)
            ->findAll()[0];

        }
        return $this->site;
    }

    // Este metodo visualiza la pagina principal del hospital

    public function indexAction(Request $request){
        return $this-> render(
            'index.html.twig',
            array("inicio" => true)
        );
    }

    // Este metodo sobreescribe el metodo render de los controladores para
    // agregar el sitio a las variables de twig

    public function render($view, array $array = array(), Response $response = null){
        $array['site'] = $this->site_config();

        return parent::render($view, $array, $response);
    }

}
