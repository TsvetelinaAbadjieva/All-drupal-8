<?php

namespace Drupal\student_entity\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;


use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Url;

/**
 * Form controller for the student_entity entity edit forms.
 *
 * @ingroup student_entity
 */
class StudentForm extends ContentEntityForm{

    public function buildForm(array $form, FormStateInterface $form_state, $extra=null){

        $form = parent::buildForm($form, $form_state);

        //entity wiil be initialized in the parent> parent object - EntityForm
        $entity = $this->entity;

        //set the displayed language
        $form['langcode'] = array(
            '#title' => $this->t('Language'),
            '#type'  => 'language_select',
            '#default_value' => $entity->getUntranslated()->language()->getId(),
            '#languages' => Language::STATE_ALL,
        ); 

        return $form;
    }


    public function save(array $form, FormStateInterface $form_state){
        
        kint('In save');
        $entity = $this->getEntity();
        kint($entity);

        $violations = $entity->validate();
        kint($violations->count());
        // if($violations->count()> 0){
        //     drupal_set_message($this->t('Please provide a valid information'));
        //     kint($violations->count());

        // } else {
            $status = $entity->save();    
            if($status){
                drupal_set_message($this->t('Student entity %e has been updated', ['%e' => $entity->toLink()->toString()]));
            } else {
                drupal_set_message($this->t('Student entity %e has been added', ['%e' => $entity->toLink()->toString()]));
            }
            $form_state->setRedirect('entity.student_entity.collection');
        // }
    }

    public function validateForm(array &$form, FormStateInterface $form_state){

        $flag = true;
          
         if(!$form_state->hasValue('first_name') || strlen($form_state->getValue('first_name')[0]['value']) < 3){
            $form_state->setErrorByName('first_name', t('Field "first name" is required and must be not less than 3 symbols'));
            $flag = false;
         }

         if(!$form_state->hasValue('last_name') || strlen($form_state->getValue('last_name')[0]['value']) < 5){
            $form_state->setErrorByName('last_name', t('Field "last name" is required and must be not less than 5 symbols'));
            $flag = false;
         }
        
         if(!$form_state->hasValue('faculty_number') || strlen($form_state->getValue('faculty_number')[0]['value'])!= 8){
            $form_state->setErrorByName('faculty_number', t('Field "faculty_nimber" is required number and must be exactly 8 symbols'));
            $flag = false;
            
         } elseif(!is_numeric((int)$form_state->getValue('faculty_number')[0]['value'])){
            $form_state->setErrorByName('faculty_number', t('Field is NOT a number'));
            $flag = false;
         }

         if(!$form_state->hasValue('gender') && $form_state->getValue('gender')[0]['value'] == null){
        
            $form_state->setErrorByName('gender', t('Field "gender" is not selected'));
            $flag = false;
         } 
    
        return $flag;
    }
}