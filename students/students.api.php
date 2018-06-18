<?php

function students_node_grants_alter(&$grants, $account, $op) {
    // Our sample module never allows certain roles to edit or delete
    // content. Since some other node access modules might allow this
    // permission, we expressly remove it by returning an empty $grants
    // array for roles specified in our variable setting.
  
    // Get our list of banned roles.
    $restricted = variable_get('students_restricted_roles', array());
  
    if ($op != 'view' && !empty($restricted)) {
      // Now check the roles for this account against the restrictions.
      foreach ($restricted as $role_id) {
        if (isset($account->roles[$role_id])) {
          $grants = array();
        }
      }
    }
  }