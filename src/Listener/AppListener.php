<?php


namespace App\Listener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;

class AppListener implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'kernelException',
            KernelEvents::REQUEST   => 'requestListener',
            KernelEvents::FINISH_REQUEST => 'finishRequestListener'
        ];
    }

    public function kernelException(GetResponseForExceptionEvent $event)
    {
        dump($event);die;
    }

    public function requestListener(GetResponseEvent $event)
    {
//        dump($event->getRequest());die;
    }

    public function finishRequestListener(FinishRequestEvent $event)
    {
//        dump($event);die;
    }
}