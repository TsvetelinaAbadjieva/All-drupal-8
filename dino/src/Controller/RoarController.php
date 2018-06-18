<?php

namespace Drupal\dino\Controller;

use Drupal\dino\Jurasic\RoarGenerator;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;


class RoarController extends ControllerBase
{
    protected $roarGenerator;
    protected $loggerFactory;

    public function __construct(RoarGenerator $roarGenerator, LoggerChannelFactoryInterface $loggerFactory){
        $this->roarGenerator = $roarGenerator;
        $this->loggerFactory = $loggerFactory;
    }
    public function roar($count){

        // $roarGenerator  = new RoarGenerator();
        // $keyValueStore = $this->keyValue('dino');
        $roar = $this->roarGenerator->getRoar($count);
        // $roar = $keyValueStore->get('roar_string');
        $keyValueStore->set('roar_string', $roar);

        $this->loggerFactory->get('default')->debug($roar);
        
        return new Response($roar);
    }
/**
 * This function create lives in the ControllerBase
 */
    public static function create(ContainerInterface $container){

        $roarGenerator = $container->get('dino_roar.roar_generator');
        $loggerFactory = $container->get('logger.factory');
        return new static($roarGenerator, $loggerFactory);
        //this will be called before the constructor and will fulfill the object RoarController
    }
}