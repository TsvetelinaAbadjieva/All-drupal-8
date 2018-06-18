<?php
namespace Drupal\student_entity\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Drupal\Plugin\Validation\Constraint\UniqueInteger;


class UniqueIntegerValidator extends ConstraintValidator{
    public $min_value = 10000000;
    public $max_value = 99999999;
    public $entity_type= 'student_entity';

    //this function use the $context from the interface
    public function validate($item, Constraint $constraint){

        $entity_type = $this->entity_type;

            if(!is_int($item->value)){
                $this->context->addViolation($constraint->notInteger, ['%value'=> $item->value]);
            }
            if($this->notUnique($item)){
                $this->context->addViolation($constraint->notUnique, ['%value'=> $item->value]);
            }
            if(!$this->range($item->value)){
                $this->context->addViolation($constraint->between, ['%value'=> $item->value, '%arg1' => $this->min_value, '%arg2'=> $this->max_value]);
            }
    }

    public function notUnique($item){

        $value = $item->value;
        // $entity_type_id = $item->getEntityTypeId();
        $value_taken = (bool) \Drupal::entityQuery($this->entity_type)
         ->condition('faculty_number',  $value)
         ->range(0, 1)
         ->count()
         ->execute();
         return $value_taken;
    }

    public function range($item){

        if(($item > $this->min_value) && ($item < $this->max_value)){
            return true;
        }
        return false;
    }
}