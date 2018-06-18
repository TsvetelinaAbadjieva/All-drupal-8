<?php

namespace Drupal\dino\Jurasic;

use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;

class RoarGenerator{
    
    private $keyvalueFactory;
    private $usecache;

    public function __constructor(KeyVavueFactoryInterface $keyvalueFactory, $usecache){
        $this->keyvalueFactory = $keyvalueFactory;
        $this->usecache = $usecache;
    }
    public function getRoar($count){

        $key = 'roar_'.$count;

 //get the store by name 'dino'      
        $store = $this->keyvalueFactory->get('dino');

 //check if the cahche - store has defined key and get it
        if($this->usecache && $store->has($key)){
            return $key;
        }
        sleep(2);
        $roar = "R".str_repeat('0',$count).'AR!';
        $store->set($key, $roar);

        return $roar;
    } 
}