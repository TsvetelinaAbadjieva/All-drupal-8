<?php

namespace Drupal\dino\Jurasic;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class DinoListener implements EventSubscriberInterface{

    public function onKernelRequest(GetResponseEvent $event){
        
        $request = $event->getRequest();
        $shouldRoar = $request->query->get('roar');
        if($shoudRoar){
            var_dump('Roooor');die;
        }
    }

    public static function getSubscribedEvents(){
        return [
            KernelEvents::REQUEST=> 'onKernelRequest',
        ];
    }
}