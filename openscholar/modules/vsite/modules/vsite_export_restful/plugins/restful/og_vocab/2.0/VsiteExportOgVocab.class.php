<?php

class VsiteExportOgVocab extends \RestfulEntityBase {

  /**
   * {@inheritdoc}
   */
  public function publicFieldsInfo() {
    $fields = parent::publicFieldsInfo();

    $fields['vid'] = array(
      'property' => 'vid',
    );

    $fields['entity_type'] = array(
      'property' => 'entity_type',
    );

    $fields['bundle'] = array(
      'property' => 'bundle',
    );

    $fields['field_name'] = array(
      'property' => 'field_name',
    );

    $fields['settings'] = array(
      'property' => 'settings',
    );

    unset($fields['self'], $fields['label']);

    return $fields;
  }


  /**
   * Override checkEntityAccess()
   */
  protected function checkEntityAccess($op, $entity_type, $entity) {

    global $user;
    $acct_id = $user->uid;

    $method = $this->getMethod();

    // For GET method, allow access based on backup perm.
    if ($method == \RestfulBase::GET) {

      // If called as user 1 (programmatically, maybe during cron), free pass.
      if ($acct_id === '1') {
        return TRUE;
      }

      return vsite_og_user_access('access vsite backup');
    }
    // For POST, PATCH, PUT, DELETE, or anything else, you need stronger perms.
    else {
      // Importing, don't have context, and this is a sensitive admin-only
      // action, so use plain user_access() check.
      return user_access('administer vsite import');
    }

  }
  /**
   * {@inheritdoc}
   */
  /*
  protected function checkEntityAccess($op, $entity_type, $entity) {
    if ($this->getMethod() == \RestfulBase::GET) {
      return TRUE;
    }

    $vid = $this->getMethod() == \RestfulBase::POST ? $this->request['vid'] : $entity->vid;
    if (!$relation = og_vocab_relation_get($vid)) {
      throw new \RestfulBadRequestException('The vocabulary is not relate to any group.');
    }

    spaces_set_space(vsite_get_vsite($relation->gid));
    $this->getAccount();

    $permissions = array(
      \RestfulBase::POST => 'administer taxonomy',
      \RestfulBase::PATCH => 'edit terms',
      \RestfulBase::PUT => 'edit terms',
      \RestfulBase::DELETE => 'delete terms',
    );

    return vsite_og_user_access($permissions[$op]);
  }
  */

  /**
   * {@inheritdoc}
   */
  protected function checkPropertyAccess($op, $public_field_name, EntityMetadataWrapper $property_wrapper, EntityMetadataWrapper $wrapper) {
    return TRUE;
  }

  public function entityValidate(\EntityMetadataWrapper $wrapper) {
    $query = new EntityFieldQuery();
    $results = $query
      ->entityCondition('entity_type', 'og_vocab')
      ->propertyCondition('entity_type', $this->request['entity_type'])
      ->propertyCondition('bundle', $this->request['bundle'])
      ->propertyCondition('vid', $this->request['vid'])
      ->execute();

    if (!empty($results['og_vocab'])) {
      $params = array(
        '@entity_type' => $this->request['entity_type'],
        '@bundle' => $this->request['bundle'],
      );
      throw new \RestfulBadRequestException(format_string('OG vocabulary already exists for @entity_type:@bundle', $params));
    }
  }

  public function entityPreSave(\EntityMetadataWrapper $entity) {
    $settings = $entity->settings->value();
    $settings += array(
      'required' => FALSE,
      'widget_type' => 'options_select',
      'cardinality' => FIELD_CARDINALITY_UNLIMITED,
    );
    $entity->settings->set($settings);
  }

}
