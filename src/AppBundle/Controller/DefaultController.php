<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Site;


class DefaultController extends Controller{

    protected $site = FALSE;

    // Este metodo permite obtener la instancia del sitio actual (singleton).
    protected function site_config(){
        if(!$this->site){
            $this->site = $this->getDoctrine() 
            ->getRepository(Site::class)
            ->findAll()[0];

        }
        return $this->site;
    }

    // Este metodo visualiza la pagina principal del hostital

    public function indexAction(Request $request){
        return $this-> render(
            'index.html.twig',
            array("inicio" => true)
        );
    }
}
