<?php

namespace Drupal\student_entity;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
//this file check the user access to operations add, edit, delete, view based on the rights specified in the permissions.yml file

class StudentAccessControllerHandler extends EntityAccessControlHandler{
    /**
     * {@inheritdoc}
     * check access against the permissions defined in permissions.yml
     */
    
    protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account){
        switch($operation){
            case 'view':
                return AccessResult::allowedIfHasPermission($account, 'view student entity');
            case 'edit':
                return AccessResult::allowedIfHasPermission($account, 'edit student entity');

            case 'delete':
                return AccessResult::allowedIfHasPermission($account, 'delete student entity');

        }
        return AccessResult::allowed();
    }
    /**
     * {@inheritdoc}
     * Separated function for check  CREATE access  against the permissions defined in permissions.yml
     * because entity is not existing at first
     * $context is array with settings
     * $context = [
     * 'langcode' =>,
     *  'entity_type_id'=>,
     *  'operation' => $operation,
     *  'field_definition' => $field_definition,
     *  'items' => $items,
     *  'account' => $account,
     *   ];
     * 
     */
    protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL){
            return AccessResult::allowedIfHasPermission($account, 'add student entity');
    }
    
}