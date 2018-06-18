<?php

namespace Drupal\student_entity\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Config\Entity\ConfigEntityBase;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityViewBuilder;
use Drupal\views\EntityViewsData;
use Drupal\user\UserInterface;

use Drupal\student_entity\StudentEntityInterface;
use Drupal\student_entity\Entity\Controller\StudentListBuilder;
use Drupal\student_entity\Form\StudentForm;
use Drupal\student_entity\Form\StudentDeleteForm;
use Drupal\student_entity\StudentAccessControllerHandler;
use Drupal\student_entity\Plugin\Violation\Constraint\UniqueInteger;
use Drupal\student_entity\Plugin\Violation\Constraint\UniqueIntegerValidator;


/**
 * @ingroup student_entity;
 * 
 * @ContentEntityType(
 *   id = "student_entity",
 *   label = @Translation("Student Entity"),
 *   handlers = {
 *      "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *      "list_builder" = "Drupal\student_entity\Entity\Controller\StudentListBuilder",
 *      "views_data"   = "Drupal\views\EntityViewsData",
 *      "form" = {
 *           "add"  = "Drupal\student_entity\Form\StudentForm",
 *           "edit" = "Drupal\student_entity\Form\StudentForm",
 *           "delete" = "Drupal\student_entity\Form\StudentDeleteForm"
 *      },
 *      "access"      = "Drupal\student_entity\StudentAccessControllerHandler", 
 *    },
 *   base_table = "students",
 *   admin_permission = "administer student entity",
 *   fieldable        = TRUE,
 *   entity_keys      = {
 *      "id"    = "id",
 *      "uuid"  = "uuid",
 *    },
 *    links = {
 *      "canonical"   = "/student_entity/{student_entity}",
 *      "edit-form"   = "/student_entity/{student_entity}/edit",
 *      "delete-form" = "/student_entity/{student_entity}/delete",
 *      "collection"  = "/student_entity/list",
 *    },
 *    field_ui_base_route = "student_entity.student_settings"
 * )
 */
class StudentEntity extends ContentEntityBase implements StudentEntityInterface{
    use EntityChangedTrait; 


    /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
    public static function preCreate(EntityStorageInterface $storageController, array &$values){

        parent::preCreate($storageController, $values);
        $values += array(
            'user_id' => \Drupal::currentUser()->id(),
        );

    }

    /**
   * {@inheritdoc}
   *
   * Specify getters and setters using instance from the parent Class Entity, EntityManager
   */
   public function getCreatedTime(){
       return $this->get('created')->value;
   }

    /**
   * {@inheritdoc}
   *
   * Get the owner that created this entity using instance from the parent Class Entity, EntityManager
   */
   public function getOwner(){
       return $this->get('user_id')->entity;
   }
    /**
   * {@inheritdoc}
   *
   * Get tho ownerId who created this entity using instance from the parent Class Entity, EntityManager
   */
  public function getOwnerId(){
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  public function setFirstName($first_name) {
    $this->set('first_name', $first_name);
    return $this;
  }

  public function getFirstName() {
    return $this->get('first_name')->value;
  }

  public function setLastName($last_name) {
    $this->set('last_name', $last_name);
    return $this;
  }
  
  public function getLastName() {
    return $this->get('last_name')->value;
  }

  public function setFacultyNumber($faculty_number) {
    $this->set('faculty_number', $faculty_number);
    return $this;
  }
  
  public function getFacultyNumber() {
    return $this->get('faculty_number')->value;
  }

  public function setGender($gender) {
    $this->set('gender', $gender);
    return $this;
  }
  
  public function getGender() {
    return $this->get('gender')->value;
  }

 /**
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

      //set primary key field
      $fields['id'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('ID'))
            ->setDescription(t('The ID for the Student content entity'))
            ->setReadOnly(true);

     // set uuid for external usage by other applications. we use predefined type uuid
     $fields['uuid'] = BaseFieldDefinition::create('uuid')  
            ->setLabel(t('UUID'))
            ->setDescription(t('The UUID of the Student Entity'))
            ->setReadOnly(true);


     // set name field for Student Entity and display options about the field visualisation in froms and views  

     // set First Name Last Name field for Student Entity and display options about the field visualisation in froms and views  
     $fields['first_name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('First Name'))
            ->setDescription(t('Student First Name'))
            ->setSettings(array(
                'default_value'   => '',
                'max_length'      => 255,
                'text_processing' => 0,
            ))
            ->addPropertyConstraints('value', ['Length'=>['min'=> 3, 'max'=> 255]])

            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type'  => 'string',
                'weight'=> -5
            ))
            ->setDisplayOptions('form' , array(
                'type'   => 'string_textfield',
                'type'   => 'string',
                'weight' => -5
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

    $fields['last_name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Last Name'))
            ->setDescription(t('Student Last Name'))
            ->setSettings(array(
                'default_value'   => '',
                'max_length'      => 255,
                'text_processing' => 0,
            ))
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type'  => 'string',
                'weight'=> -5
            ))
            ->setDisplayOptions('form' , array(
                'type'   => 'string_textfield',
                'type'   => 'string',
                'weight' => -5
             ))
             ->setDisplayConfigurable('form', TRUE)
             ->setDisplayConfigurable('view', TRUE);

    // Gender field for the contact.
    // ListTextType with a drop down menu widget.
    // The values shown in the menu are 'male' and 'female'.
    // In the view the field content is shown as string.
    // In the form the choices are presented as options list.  
     $fields['gender'] = BaseFieldDefinition::create('list_string')
            ->setLabel(t('Gender'))
            ->setDescription(t('Student gender')) 
            ->setSettings(array(
                'allowed_values' => array(
                    'male'   => 'male',
                    'female' => 'female'
                    )) )
            // ->addConstraint('Range'=> ['male', 'female'])        
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type'  => 'list_default',
                'weight'=> -4
            )) 
            ->setDisplayOptions('form', array(
                    'type'  => 'options_select',
                    'weight'=> -4
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);    
     
    //Set Student FacultyNumber
    $fields['faculty_number'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('Faculty Number'))
            ->setDescription(t('Student Faculty Number'))
            ->addConstraint('unique_integer')
            // ->addConstraint('UniqueField')

            // ->setPropertyConstraints('value', ['Range'=> ['min' => 10000000, 'max'=> 99999999]])
            ->setSettings(array(
                    'unsigned'        => TRUE,
                    'min'             => 10000000,
                    'max'             => 99999999,
                    'default_value'   => '',
                    'max_length'      => 255,
                    'text_processing' => 0,
            ))
            ->setDisplayOptions('view', array(
                    'label' => 'above',
                    'type'  => 'string',
                    'weight'=> -5
            ))
            ->setDisplayOptions('form' , array(
                    'label'  => 'above',   
                    'type'   => 'string_textfield',
                    'weight' => -5
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

    // Owner field of the Student Entity.
    // Entity reference field, holds the reference to the user object.
    // The view shows the user name field of the user.
    // The form presents a auto complete field for the user name. 
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('User Name'))
            ->setDescription('The name of the associated user')
            ->setSetting('target_type', 'user')
            ->setSetting('handler', 'default')
            ->setDisplayOptions('form' , array(
                'type'             => 'entity_reference_autocomplete',
                'settings'         => array(
                    'match_operator' => 'CONTAINS',
                    'size'           => 60,
                    'autocomplete_type' => 'tags',
                    'placeholder'    => '',
                ),
                'weight' => -3,
            ))   
            ->setDisplayOptions('view' , array(
                'label' => 'above',
                'type' => 'entity_reference_label',
                'weight' => -3,
            ))   
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);   

    //set the language field
    $fields['langcode'] = BaseFieldDefinition::create('language')
            ->setLabel(t('Language code'))
            ->setDescription(t('Language code of Student Entity'));
       
    //set created date time for Student Entity
    $fields['created'] = BaseFieldDefinition::create('created')
            ->setLabel(t('Created'))
            ->setDescription(t('The time that Student Entity was created '));
    
    //set created date time for Student Entity
    $fields['changed'] = BaseFieldDefinition::create('changed')
            ->setLabel(t('Changed'))
            ->setDescription(t('The time that Student Entity was changed '));

     return $fields;

   }

 }