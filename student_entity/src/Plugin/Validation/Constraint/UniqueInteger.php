<?php

namespace Drupal\student_entity\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Checks that the submitted value is a unique integer.
 *
 * @Constraint(
 *   id = "unique_integer",
 *   label = @Translation("Unique Integer", context = "Validation"),
 *   type = {"integer", "entity:student_entity"}
 * )
 */
class UniqueInteger extends Constraint{

    public $notInteger = '%value is not integer';
    public $notUnique  = '%value is not unique';
    public $between    = '%value is not between %arg1 and %arg2';    
}