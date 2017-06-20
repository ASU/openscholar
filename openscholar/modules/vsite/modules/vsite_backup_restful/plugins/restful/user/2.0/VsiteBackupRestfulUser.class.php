<?php

/**
 * @file
 * Contains RestfulEntityUser__1_0.
 */

class VsiteBackupRestfulUser extends \RestfulEntityBaseUser {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['name'] = array(
      'property' => 'name',
    );

    $public_fields['password'] = array(
      'property' => 'pass',
      'callback' => array($this, 'hideField')
    );

    $public_fields['status'] = array(
      'property' => 'status',
    );

    $public_fields['role'] = array(
      'property' => 'roles',
      'process_callbacks' => array(
        array($this, 'getRoles'),
      ),
    );

    $public_fields['create_access'] = array(
      'callback' => array($this, 'getCreateAccess')
    );

    $ga_field = og_get_group_audience_fields('user','user','node');
    unset($ga_field['vsite_support_expire']);

    if(count($ga_field)) {
      $public_fields['og_user_node'] = array(
        'property' => key($ga_field),
        'process_callbacks' => array(
          array($this, 'vsiteFieldDisplay'),
        ),
      );
    }

    return $public_fields;
  }

  /**
   * Hide the field value.
   *
   * @return null
   */
  protected function hideField() {
    return NULL;
  }

  /**
   * Overriding the create entity method in order to load the password.inc file.
   */
  public function createEntity() {
    require_once DRUPAL_ROOT . '/' . variable_get('password_inc', 'includes/password.inc');
    return parent::createEntity();
  }

  /**
   * Refactor the roles property with rid-name format.
   */
  public function getRoles($roles) {
    $return = array();
    foreach ($roles as $role) {
      $info = user_role_load($role);
      $return[$info->rid] = $info->name;
    }
    return $return;
  }

  /**
   * Returns whether a user can create new sites or not
   */
  public function getCreateAccess() {
    if (module_exists('vsite')) {
      return _vsite_user_access_create_vsite();
    }
  }

  /**
   * Display the id and the title of the group.
   */
  public function vsiteFieldDisplay($values) {
    $account = $this->getAccount();
    ctools_include('subsite', 'vsite');

    $groups = array();
    // Obtaining associative array of custom domains, keyed by space id
    $custom_domains = $this->getCustomDomains($values);
    $purl_base_domain = variable_get('purl_base_domain');
    foreach ($values as $value) {
      $groups[] = array(
        'title' => $value->title,
        'id' => $value->nid,
        'purl' => $value->purl,
        'delete_base_url' => isset($custom_domains[$value->nid]) ? 'http://' . $custom_domains[$value->nid] . '/#overlay=' : $purl_base_domain . '/#overlay=' . $value->purl . '/',
        'owner' => ($value->uid == $account->uid),
        'subsite_access' => vsite_subsite_access('create', $value),
        'delete_access' => node_access('delete', $value),
      );
    }
    return $groups;
  }

  /**
   * Returns associative array of custom domains, keyed by space id
   */
  protected function getCustomDomains($vsites) {
    $space_ids = array();
    foreach ($vsites as $vsite) {
      $space_ids[] = $vsite->nid;
    }
    $result = db_select('purl', 'p')
      ->fields('p', array('id', 'value'))
      ->condition('provider', 'vsite_domain', '=')
      ->condition('id', $space_ids, 'IN')
      ->execute()
      ->fetchAllKeyed(0, 1);
    return $result;
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
      if (!$this->checkPropertyAccess('edit', $public_field_name, $wrapper->{$property_name}, $wrapper)) {
        throw new \RestfulBadRequestException(format_string('Property @name cannot be set.', array('@name' => $public_field_name)));
      }

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


}
