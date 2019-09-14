<?php


namespace App\Subscriber\KernelEventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {

//        $route = $event->getRequest()->attributes->get('_route_params');
//
//        dump(explode('/',$route['route']));die;
//        $event->getRequest()->attributes->set('_route_params' , ["route" => "/company/login"]);
    }


}