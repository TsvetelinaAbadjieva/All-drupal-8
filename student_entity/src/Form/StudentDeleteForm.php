<?php

namespace Drupal\student_entity\Form;

use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a form for deleting a student_entity entity.
 *
 * @ingroup student_entity
 */
class StudentDeleteForm extends ContentEntityDeleteForm {
    
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form = parent::buildForm($form, $form_state);
        return $form;
    }
}
?>