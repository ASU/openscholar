<?php

class GroupNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    unset($public_fields['body']);

    $public_fields['users'] = array(
      'property' => 'nid',
      'process_callbacks' => array(
        array($this, 'getGroupUsers'),
      ),
    );

    $public_fields['preset'] = array(
      'property' => 'preset',
    );

    $public_fields['purl'] = array(
      'property' => 'domain',
    );

    $public_fields['type'] = array(
      'property' => 'type',
    );


    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_organization'] = array(
      'property' => 'field_organization',
    );
    $public_fields['group_group'] = array(
      'property' => 'group_group',
    );
    $public_fields['field_group_path'] = array(
      'property' => 'field_group_path',
    );
    $public_fields['field_site_description'] = array(
      'property' => 'field_site_description',
    );
    $public_fields['field_site_address'] = array(
      'property' => 'field_site_address',
    );
    $public_fields['field_site_logo'] = array(
      'property' => 'field_site_logo',
    );
    $public_fields['field_group_parent'] = array(
      'property' => 'field_group_parent',
    );
    $public_fields['field_subsite_domains'] = array(
      'property' => 'field_subsite_domains',
    );
    $public_fields['group_access'] = array(
      'property' => 'group_access',
    );
    $public_fields['field_meta_description'] = array(
      'property' => 'field_meta_description',
    );
    $public_fields['og_roles_permissions'] = array(
      'property' => 'og_roles_permissions',
    );


    return $public_fields;
  }

  /**
   * @param EntityFieldQuery $query
   *
   * Overriding the query list filter. Since this is a group a handler we need
   * to select nodes of 3 types: personal, project, department AKA group.
   */
  public function queryForListFilter(\EntityFieldQuery $query) {
    parent::queryForListFilter($query);

    $query->propertyCondition('type', array(
      'personal',
      'project',
      'department'
    ), 'IN');
  }

  /**
   * Return all the users for this group.
   */
  public function getGroupUsers($value) {
    $query = new EntityFieldQuery();
    $results = $query
      ->entityCondition('entity_type', 'user')
      ->fieldCondition(OG_AUDIENCE_FIELD, 'target_id', $value)
      ->execute();

    $list = array();

    if (empty($results['user'])) {
      return $list;
    }

    $accounts = user_load_multiple(array_keys($results['user']));

    foreach ($accounts as $account) {
      $list[] = array(
        'uid' => $account->uid,
        'name' => $account->name,
      );
    }

    return $list;
  }

  /**
   * {@inheritdoc}
   */
  protected function setPropertyValues(EntityMetadataWrapper $wrapper, $null_missing_fields = FALSE) {
    $request = $this->getRequest();
    self::cleanRequest($request);
    $wrapper->type->set($request['type']);

//    parent::setPropertyValues($wrapper, $null_missing_fields);
    $id = $wrapper->getIdentifier();

    if (!$space = vsite_get_vsite($id)) {
      return;
    }

    // Set the preset on the object.
    if ($request['preset']) {
      $space->controllers->variable->set('spaces_preset_og', $request['preset']);
    }

    if ($purl = $wrapper->domain->value()) {
      $modifier = array(
        'provider' => 'spaces_og',
        'id' => $id,
        'value' => $purl,
      );
      purl_save($modifier);
    }
  }


  /**
   * {@inheritdoc}
   *
   * Copied from RestfulEntityBase.
   */
  public function createEntity() {

    $entity = entity_create($this->entityType, $this->request);

    $wrapper = entity_metadata_wrapper($this->entityType, $entity);

    $this->setPropertyValues($wrapper);

    $wrapper->save();

    return array($this->viewEntity($wrapper->getIdentifier()));
  }


  /**
   * {@inheritdoc}
   *
   * Copied from RestfulEntityBase.
   */
  public function process($path = '', array $request = array(), $method = \RestfulInterface::GET, $check_rate_limit = TRUE) {
    $this->setMethod($method);
    $this->setPath($path);
    $this->setRequest($request);

    // Clear all static caches from previous requests.
    $this->staticCache->clearAll();

    // Override the range with the value in the URL.
    $this->overrideRange();

    $version = $this->getVersion();
    $this->setHttpHeaders('X-API-Version', 'v' . $version['major'] . '.' . $version['minor']);

    if (!$method_name = $this->getControllerFromPath()) {
      throw new RestfulBadRequestException('Path does not exist');
    }

    if ($check_rate_limit && $this->getRateLimitManager()) {
      // This will throw the appropriate exception if needed.
      $this->getRateLimitManager()->checkRateLimit($request);
    }

    $return = $this->{$method_name}($path);

    if (empty($request['__application']['rest_call'])) {
      // Switch back to the original user.
      $this->getAuthenticationManager()->switchUserBack();
    }


    return $return;

  }


  /**
   * Validate an entity before it is saved.
   *
   * Overridden from RestfulEntityBase.
   *
   * @param \EntityMetadataWrapper $wrapper
   *   The wrapped entity.
   *
   * @throws \RestfulBadRequestException
   */
  public function entityValidate(\EntityMetadataWrapper $wrapper) {
    if (!module_exists('entity_validator')) {
      // Entity validator doesn't exist.
      return;
    }

    if (!$handler = entity_validator_get_validator_handler($wrapper->type(), $wrapper->getBundle())) {
      // Entity validator handler doesn't exist for the entity.
      return;
    }

    if ($handler->validate($wrapper->value(), TRUE)) {
      // Entity is valid.
      return;
    }

    $errors = $handler->getErrors(FALSE);

    $map = array();
    foreach ($this->getPublicFields() as $field_name => $value) {
      if (empty($value['property'])) {
        continue;
      }

      if (empty($errors[$value['property']])) {
        // Field validated.
        continue;
      }

      $map[$value['property']] = $field_name;
      $params['@fields'][] = $field_name;
    }

    if (empty($params['@fields'])) {
      // There was a validation error, but on non-public fields, so we need to
      // throw an exception, but can't say on which fields it occurred.
      throw new \RestfulBadRequestException('Invalid value(s) sent with the request.');
    }

    $params['@fields'] = implode(',', $params['@fields']);
//    $e = new \RestfulBadRequestException(format_plural(count($map), 'Invalid value in field @fields.', 'Invalid values in fields @fields.', $params));
    foreach ($errors as $property_name => $messages) {
      if (empty($map[$property_name])) {
        // Entity is not valid, but on a field not public.
        continue;
      }

      $field_name = $map[$property_name];

      foreach ($messages as $message) {

        $message['params']['@field'] = $field_name;
        $output = format_string($message['message'], $message['params']);

//        $e->addFieldError($field_name, $output);
      }
    }

    // Throw the exception.
//    throw $e;
  }

  /**
   * Determine if an entity is valid, and accessible.
   *
   * @param $op
   *   The operation to perform on the entity (view, update, delete).
   * @param $entity_id
   *   The entity ID.
   *
   * @return bool
   *   TRUE if entity is valid, and user can access it.
   *
   * @throws RestfulUnprocessableEntityException
   * @throws RestfulForbiddenException
   */
  protected function isValidEntity($op, $entity_id) {
    $entity_type = $this->entityType;

    $params = array(
      '@id' => $entity_id,
      '@resource' => $this->getPluginKey('label'),
    );

    if (!$entity = entity_load_single($entity_type, $entity_id)) {
      throw new RestfulUnprocessableEntityException(format_string('The entity ID @id for @resource does not exist.', $params));
    }

    list(,, $bundle) = entity_extract_ids($entity_type, $entity);

    $resource_bundle = $this->getBundle();
    if ($resource_bundle && $bundle != $resource_bundle) {
      throw new RestfulUnprocessableEntityException(format_string('The entity ID @id is not a valid @resource.', $params));
    }

    if ($this->checkEntityAccess($op, $entity_type, $entity) === FALSE) {

      if ($op == 'view' && !$this->getPath()) {
        // Just return FALSE, without an exception, for example when a list of
        // entities is requested, and we don't want to fail all the list because
        // of a single item without access.
        return FALSE;
      }

      // Entity was explicitly requested so we need to throw an exception.
      throw new RestfulForbiddenException(format_string('You do not have access to entity ID @id of resource @resource', $params));
    }

    return TRUE;
  }

  /**
   * Override checkEntityAccess()
   */
  public function checkEntityAccess($op, $entity_type, $entity) {

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

}
