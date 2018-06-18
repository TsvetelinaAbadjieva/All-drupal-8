<?php

namespace Drupal\my_test\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\my_test\Client\MyClient;
use Symfony\Component\HttpFoundation\Response;

class MyTestFormController extends ControllerBase{

    protected $client;
     
    public function __construct(MyClient $client){
        $this->client = $client;
        
     }

     public static function create(ContainerInterface $container){
        echo'<pre>';
        var_dump($container->get('my_test.client'));
        echo'</pre>';
        return new static($container->get('my_test.client'));
    } 

    public function data(){
        return [
            'key1'=>'value1',
            'key2'=> 'value2'
        ];
    }

    public function request($method, $endpoint, $query, $body){
        $response = [];
        $response = $this->httpClient->{$method}(
            $this->base_uri.$endpoint,
            $this->buildOptions($query, $body)
        );
        if(!$response){
            sleep(2);
        }
        return $response;
    }
    /**
     * implements @hook_form()
     */
    public function build(){
        $data = json_decode($this->request('GET','/form/show',['Content-type'=> 'application/json'],json_encode($this->data())));
        return new Response($data);
    }
}