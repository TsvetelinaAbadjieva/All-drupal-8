<?php

namespace Drupal\student_entity\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class StudentSettingsForm extends FormBase {
    /**
     * @ingroup student_entity
     * Defines form ID and returns it
     */
    public function getFormId(){
        return 'student_entity.student_settings';
    }
    public function buildForm(array $form, FormStateInterface $form_state){
        $form['student_settings']['#markup'] = '<h1>Settings for content entity Student. Manage field settings here.</h1> ';
        return $form;
    }

    // leaved empty because it is implemented in the base class
    public function submitForm(array &$form, FormStateInterface $form_state){

    }
}