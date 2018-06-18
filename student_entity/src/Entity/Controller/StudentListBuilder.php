<?php

namespace Drupal\student_entity\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Provides a list controller for student_entity  entity.
 *
 * @ingroup student_entity
 */
class StudentListBuilder extends EntityListBuilder {

    /**
   * {@inheritdoc}
   *
   * Render the Student Entity as a table with header rows.
   *
   * Calling the parent::render() we call methods buildHeader and buildRow from the same class
   */
    public function render(){

      $build['description'] = [
            '#markup' =>  $this->t('This Content Type Entity is a fieldable entity. Manage fields on <a href="@adminlink">Students admin page</a>', 
            ['@adminlink' => (new URL('student_entity.student_settings'))->toString()])
        ];
        $build += parent::render();
        return $build;
    }

    /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the contact list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader(){

    $header['id'] = $this->t('Student ID');
    $header['first_name'] = $this->t('First Name');
    $header['last_name'] = $this->t('Last Name');
    $header['faculty_number'] = $this->t('Faculty Number');
    $header['gender'] = $this->t('Gender');

    return $header + parent::buildHeader();

  }
  public function buildRow(EntityInterface $entity){

    $row['id'] = $entity->id();
    // $row['link'] = $entity->link();
    $row['first_name'] = $entity->first_name->value;
    $row['last_name'] = $entity->last_name->value;
    $row['faculty_number'] = $entity->faculty_number->value;
    $row['gender'] = $entity->gender->value;

    return $row + parent::buildRow($entity);

  }
}