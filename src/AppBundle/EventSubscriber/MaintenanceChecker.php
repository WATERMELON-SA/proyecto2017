<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Controller\MaintenanceController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class MaintenanceChecker implements EventSubscriberInterface{

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller) || (!$controller[0] instanceOf MaintenanceController)) {
            return;
        }

            var_dump($controller[0]->site_config()->getSitioHabilitado());
        if (!$controller[0]->site_config()->getSitioHabilitado()) {
            return $this->forward('AppBundle:Site:show_maintenance',array());
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
        );
    }
}

?>