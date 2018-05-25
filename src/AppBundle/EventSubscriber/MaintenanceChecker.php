<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Controller\MaintenanceController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

        if (!$controller[0]->site_config()->getSitioHabilitado()) {
            $redirectUrl = '/maintenance';
             $event->setController(function() use ($redirectUrl) {
                return new RedirectResponse($redirectUrl);
             });
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