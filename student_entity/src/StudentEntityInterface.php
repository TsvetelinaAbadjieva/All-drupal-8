<?php

namespace Drupal\student_entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Student entity.
 * @ingroup content_entity_example
 */
interface StudentEntityInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface{
    
}