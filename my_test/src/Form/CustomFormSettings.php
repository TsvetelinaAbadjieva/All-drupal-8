<?php

namespace Drupal\my_test\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Url;


//ConfigFormBase Base class for implementing system configuration forms.
//It extends also FORMBASE
class CustomFormSettings extends ConfigFormBase{

/**
*{@inheritdoc}
*Implements getId() from FormBaseInterface
*/

public function getFormId(){
 return 'form_module.settings';
}

/**  
   * {@inheritdoc}  
   */  
  protected function getEditableConfigNames() {  
    return [  
      'form_module.settings',  
    ];  
  }  
/**
*{@inheritdoc}
*implement builForm() from FormBaseInterface
*/
public function buildForm(array $form, FormStateInterface $form_state){

    $config = $this->config('form_module.settings');  

    //will produce a form with a field custom_field
  
	$form['custom_field'] = [
		'#type' => 'textfield',
        '#title'=> $this->t('Custom form'),
        '#description'=> $this->t('This is custom text field'),
        '#default_value'=> $config->get('welcome_message'),
        '#required' => true
    ];
    $form['video'] = [
		'#type' => 'textfield',
        '#title'=> $this->t('Youtube Video link'),
        '#description'=> $this->t('This is custom video field'),
        '#default_value'=> $config->get('welcome_video'),
        '#required' => true,
        
    ];
    $form['phone_number'] = array(
        '#type' => 'tel',
        '#title' => $this->t('Your phone number'),
        '#description'=> $this->t('This is phone number field'),
        '#required' => true,
        '#default_value'=> $config->get('welcome_number'),
        '#number' =>$this->t('Field MUST be a number'),
      );
	return parent::buildForm($form, $form_state);
}

/**
 * 
 * {@inheritdoc}
 */
public function validateForm(array &$form, FormStateInterface $form_state){

//validate URL
 if(!UrlHelper::isValid($form_state->getValue('video'), true)){
     $form_state->setErrorByName('video', $this->t("Video url %url is invalid"), array('%url'=> $form_state->getValue('video')));
 }
  
 if(!$form_state->hasValue('custom_field') || strlen($form_state->getValue('custom_field'))<3){
    $form_state->setErrorByName('custom_field', t('Field is required and must be not less than 3 symbols'));
 }

 if(!$form_state->hasValue('phone_number') || strlen($form_state->getValue('phone_number'))<6){

    $form_state->setErrorByName('phone_number', t('Field is required number and must be not less than 6 symbols'));

    
 } 
  elseif(!is_numeric($form_state->getValue('phone_number'))){
    echo 'In !is_numeric';
    $form_state->setErrorByName('phone_number', t('Field is NOT a number'));
 }
 
}

/**
 * {@inheritdoc} 
 */
public function submitForm(array &$form, FormStateInterface $form_state){
    // echo '<pre>';
    // var_dump($form_state['values']);
    // echo '</pre>';
    $body = [];
    foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
        $body[$key] = $value;
      }
      $options = array(
        'headers' => array(
        //   'Client-ID:**********',
        //   'Authorization: Bearer ********',
          'Content-Type:application/json',
         ),
         'method' => 'POST',
        'data'=> drupal_json_encode($body),
      );
    
   $url = URL::fromRoute('my_test.my_test.client', $options);
   $form_state->setRedirect($url);

    $this->config('form_module.settings')  
      ->set('welcome_message', $form_state->getValue('welcome_message'))
      ->set('welcome_video', $form_state->getValue('welcome_video'))  
      ->set('phone_number', $form_state->getValue('phone_number'))
      ->save();  
      
    parent::submitForm($form, $form_state);
    }
}
