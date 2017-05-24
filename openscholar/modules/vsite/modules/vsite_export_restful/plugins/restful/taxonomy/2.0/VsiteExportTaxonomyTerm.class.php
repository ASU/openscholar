<?php

class VsiteExportTaxonomyTerm extends VsiteExportRestfulEntityCacheableBase {

  /**
   * {@inheritdoc}
   */
  public function publicFieldsInfo() {
    $fields = parent::publicFieldsInfo();

    $fields['vocab'] = array(
      'property' => 'vocabulary',
      'process_callbacks' => array(
        function($vocabulary) {
          return $vocabulary->machine_name;
        }
      ),
    );

    $fields['vid'] = array(
      'property' => 'vocabulary',
      'process_callbacks' => array(
        function($vocabulary) {
          return $vocabulary->vid;
        }
      ),
    );

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getBundle() {
    if ($this->path && !$this->fetchingUpdates()) {
      $wrapper = entity_metadata_wrapper('taxonomy_term', $this->path);
      return $wrapper->vocabulary->machine_name->value();
    }

    return $this->bundle;
  }

  /**
   * {@inheritdoc}
   */
  public function createEntity() {
    $entity_info = $this->getEntityInfo();
    $bundle_key = $entity_info['entity keys']['bundle'];
    $values = $bundle_key ? array($bundle_key => $this->bundle) : array();

    $entity = entity_create($this->entityType, $values);


    /* Functionality for admins. Don't need per-Vsite entity access checks.
    if ($this->checkEntityAccess('create', $this->entityType, $entity) === FALSE) {
      // User does not have access to create entity.
      $params = array('@resource' => $this->getPluginKey('label'));
      throw new RestfulForbiddenException(format_string('You do not have access to create a new @resource resource.', $params));
    }
    */

    $wrapper = entity_metadata_wrapper($this->entityType, $entity);

    $this->setPropertyValues($wrapper);
    return array($this->viewEntity($wrapper->getIdentifier()));
  }

  /**
   * Set properties of the entity based on the request, and save the entity.
   *
   * @param EntityMetadataWrapper $wrapper
   *   The wrapped entity object, passed by reference.
   * @param bool $null_missing_fields
   *   Determine if properties that are missing from the request array should
   *   be treated as NULL, or should be skipped. Defaults to FALSE, which will
   *   skip, instead of setting the fields to NULL.
   *
   * @throws RestfulBadRequestException
   */
  protected function setPropertyValues(EntityMetadataWrapper $wrapper, $null_missing_fields = FALSE) {
    $request = $this->getRequest();

    static::cleanRequest($request);
    $save = FALSE;
    $original_request = $request;

    foreach ($this->getPublicFields() as $public_field_name => $info) {
      if (!empty($info['create_or_update_passthrough'])) {
        // Allow passing the value in the request.
        unset($original_request[$public_field_name]);
        continue;
      }

      if (empty($info['property'])) {
        // We may have for example an entity with no label property, but with a
        // label callback. In that case the $info['property'] won't exist, so
        // we skip this field.
        continue;
      }

      $property_name = $info['property'];

      if (!array_key_exists($public_field_name, $request)) {
        // No property to set in the request.
        if ($null_missing_fields && $this->checkPropertyAccess('edit', $public_field_name, $wrapper->{$property_name}, $wrapper)) {
          // We need to set the value to NULL.
          $field_value = NULL;
        }
        else {
          // Either we shouldn't set missing fields as NULL or access is denied
          // for the current property, hence we skip.
          continue;
        }
      }
      else {
        // Property is set in the request.
        $field_value = $this->propertyValuesPreprocess($property_name, $request[$public_field_name], $public_field_name);
      }

      $wrapper->{$property_name}->set($field_value);

      // We check the property access only after setting the values, as the
      // access callback's response might change according to the field value.
      //if (!$this->checkPropertyAccess('edit', $public_field_name, $wrapper->{$property_name}, $wrapper)) {
      //  throw new \RestfulBadRequestException(format_string('Property @name cannot be set.', array('@name' => $public_field_name)));
      //}

      unset($original_request[$public_field_name]);
      $save = TRUE;
    }

    if (!$save) {
      // No request was sent.
      throw new \RestfulBadRequestException('No values were sent with the request');
    }

    if ($original_request) {
      // Request had illegal values.
      $error_message = format_plural(count($original_request), 'Property @names is invalid.', 'Property @names are invalid.', array('@names' => implode(', ', array_keys($original_request))));
      throw new RestfulBadRequestException($error_message);
    }

    // Allow changing the entity just before it's saved. For example, setting
    // the author of the node entity.
    $this->entityPreSave($wrapper);

    $this->entityValidate($wrapper);

    $wrapper->save();
  }



  /**
   * Display the name of the vocab from the vocabulary object.
   *
   * @param $value
   *   The vocabulary object.
   *
   * @return mixed
   *   The machine name of the vocabulary.
   */
  protected function processVocab($value) {
    return $value->machine_name;
  }

  /**
   * {@inheritdoc}
   *
   * Display taxonomy terms from the current vsite.
   */
  protected function queryForListFilter(\EntityFieldQuery $query) {
//    if (empty($request['vsite'])) {
//      throw new \RestfulBadRequestException(t('You need to provide a vsite.'));
//    }

    if (!$vsite = vsite_get_vsite($this->request['vsite'])) {
      return;
    }

    module_load_include('inc', 'vsite_vocab', 'includes/taxonomy');
    $vocabData = vsite_vocab_get_vocabularies($vsite);
    $requested = array();
    $badVocabs = array();

    if (!empty($this->request['vocab'])) {
      $condition = is_array($this->request['vocab']) ? $this->request['vocab'] : array($this->request['vocab']);
      foreach ($vocabData as $v) {
        if (in_array($v->machine_name, $condition)) {
          $requested[] = $v->vid;
          $condition = array_diff($condition, array($v->machine_name));
        }
      }
      $badVocabs = $condition;
    }
    elseif (!empty($this->request['vid'])) {
      $condition = is_array($this->request['vid']) ? $this->request['vid'] : array($this->request['vid']);
      foreach ($condition as $vid) {
        if (isset($vocabData[$vid])) {
          $requested[] = $vid;
        }
        else {
          $badVocabs[] = $vid;
        }
      }
    }
    else {
      // no filtered vocabs requested, so return everything based on the vsite.
      $requested = array_keys($vocabData);
    }

    if (empty($requested)) {
      throw new \RestfulBadRequestException(format_string('The vocab(s) @vocab you asked for is not part of the vsite.', array('@vocab' => explode(', ', $badVocabs))));
    }

    $query->propertyCondition('vid', $requested, 'IN');
  }

  /**
   * {@inheritdoc}
   */
  public function entityValidate(\EntityMetadataWrapper $wrapper) {
    if (!$this->getRelation($wrapper->value())) {
      // The vocabulary is not relate to any group.
      throw new \RestfulBadRequestException("The vocabulary isn't relate to any group.");
    }

    parent::entityvalidate($wrapper);
  }

  /**
   * {@inheritdoc}
   */
  protected function isValidEntity($op, $entity_id) {
    // The entity is valid since it's already been filtered in
    // self::queryForListFilter() and the access is checked in
    // self::checkEntityAccess().
    return true;
  }

  /**
   * Overrides RestfulEntityBaseTaxonomyTerm::checkEntityAccess().
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
      return vsite_og_user_access('administer vsite import');
    }

  }
  /*
  protected function checkEntityAccess($op, $entity_type, $entity) {

    if (!$relation = $this->getRelation($entity)) {
      return FALSE;
    }

    if ($op == 'view') {
      return TRUE;
    }

    // We need this in order to alter the global user object.
    $this->getAccount();

    spaces_set_space(vsite_get_vsite($relation->gid));

    if (!vsite_og_user_access('administer taxonomy')) {
      throw new \RestfulBadRequestException("You are not allowed to create terms.");
    }
  }
  */

  /**
   * Get the vocabulary relation from request.
   *
   * @return mixed
   *   OG vocab relation.
   */
  private function getRelation($entity) {
    $vocab = empty($entity->vocabulary_machine_name) ? $this->request['vocab'] : $entity->vocabulary_machine_name;
    $this->bundle = $vocab;
    return og_vocab_relation_get(taxonomy_vocabulary_machine_name_load($vocab)->vid);
  }

  /**
   * {@inheritdoc}
   */
  protected function checkPropertyAccess($op, $public_field_name, EntityMetadataWrapper $property_wrapper, EntityMetadataWrapper $wrapper) {
    // We need this in order to alter the global user object.
    $this->getAccount();

    if ($op != 'view') {
      if (module_exists('spaces')) {
        $relation = $this->getRelation(taxonomy_term_load($this->path));
        spaces_set_space(vsite_get_vsite($relation->vid));
        return vsite_og_user_access('administer taxonomy');
      }
      return parent::checkPropertyAccess($op, $public_field_name, $property_wrapper, $wrapper);
    }
    else {
      // By default, Drupal restricts access to even viewing vocabulary properties.
      // There's really no case where viewing a vocabular property is a problem though
      return true;
    }

  }

  protected function getLastModified($id) {
    // Vocabularies cannot really be editted. When they were first created isn't stored either.
    // This function is only concerned with modifications, so as long as we assume it's really old, we're fine for now
    return strotime('-31 days', REQUEST_TIME);
  }

}
