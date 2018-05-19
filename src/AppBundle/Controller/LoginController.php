<?php

// checkear para permisos: https://symfony.com/doc/3.4/best_practices/security.html

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller{

    // La accion de logueo es realizada automaticamente al hacer un POST a /login
    
    // Mediante el metodo $this->getUser() desde cualquier controlador se obtiene al usuario logueado
    // Desde twig {{app.user}} devuelve una instancia del usuario logueado

    // No es necesario implemetear "logout", mediante la ruta y lo configurado en security.yml ya esta

    // Este metodo renderiza el formulario de Login al hacer un GET a /login
    public function loginAction(
        AuthenticationUtils $authenticationUtils,
        Request $request){

        // Permite obtener los errores para mostar en las vistas
        $error        = $authenticationUtils->getLastAuthenticationError();
        // Permite obtener el nombre del usuario que fallo al loguerase
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/logIn.html.twig', 
            array('last_username' => $lastUsername,
                'error'           => $error,
        ));
    }
}

?>