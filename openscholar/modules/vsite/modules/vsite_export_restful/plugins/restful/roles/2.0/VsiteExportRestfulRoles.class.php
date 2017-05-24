<?php

/**
 * @file
 * Contains \RestfulQueryVariable
 */

class VsiteExportRestfulRoles extends \VsiteExportRestfulDataProvider {

  protected $validateHandler = 'roles';

  /**
   * {@inheritdoc}
   */
  public static function controllersInfo() {
    return array(
      '' => array(
        \RestfulInterface::GET => 'index',
        \RestfulInterface::HEAD => 'index',
        \RestfulInterface::POST => 'create',
        \RestfulInterface::DELETE => 'remove',
      ),
      // We don't know what the ID looks like, assume that everything is the ID.
      '^.*$' => array(
        \RestfulInterface::GET => 'view',
        \RestfulInterface::HEAD => 'view',
        \RestfulInterface::PUT => 'replace',
        \RestfulInterface::PATCH => 'update',
        \RestfulInterface::DELETE => 'remove',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function publicFieldsInfo() {
    return array(
      'rid' => array(
        'property' => 'rid',
      ),
      'name' => array(
        'property' => 'name',
      ),
      'gid' => array(
        'property' => 'gid',
      ),
      'group_bundle' => array(
        'property' => 'group_bundle',
      ),
      'group_type' => array(
        'property' => 'group_type',
      ),
    );
  }

  /**
   * Overrides RestfulDataProviderDbQuery::queryForListFilter().
   *
   * Display the group roles by the group ID.
   *
   * {@inheritdoc}
   */
  protected function queryForListFilter(\SelectQuery $query) {
    parent::queryForListFilter($query);

    //$request = $this->getRequest();

    if (empty($this->request['vsite'])) {
      throw new \RestfulForbiddenException('You must specify a vsite ID.');
    }


    $wrapper = entity_metadata_wrapper('node', $this->request['vsite']);

    if ($wrapper->og_roles_permissions->value()) {
      // The group override OG's default roles and permission. we need to return
      // only roles for this group.
      $query->condition('gid', $this->request['vsite']);
    }
    else {
      // The group use the default roles and permission. We need to display only
      // roles matching to the group bundle those who not relate to any group.
      $query->condition('group_bundle', $wrapper->getBundle());
      $query->condition('gid', 0);
    }
  }

  /**
   * Overrides RestfulDataProviderDbQuery::create().
   *
   * Verify the user has permission to invoke this method.
   */
  public function create() {
    $this->validate();
    $request = $this->getRequest();
    static::cleanRequest($request);
    $save = FALSE;
    $original_request = $request;

    $public_fields = $this->getPublicFields();
    $id_columns = $this->getIdColumn();


    $record = array();
    foreach ($public_fields as $public_field_name => $info) {
      // Ignore passthrough public fields.
      if (!empty($info['create_or_update_passthrough'])) {
        unset($original_request[$public_field_name]);
        continue;
      }

      // If this is the primary field, skip.
      if ($this->isPrimaryField($info['property'])) {
        unset($original_request[$public_field_name]);
        continue;
      }

      if (isset($request[$public_field_name])) {
        $record[$info['property']] = $request[$public_field_name];
      }

      unset($original_request[$public_field_name]);
      $save = TRUE;
    }

    // No request was sent.
    if (!$save) {
      throw new \RestfulBadRequestException('No values were sent with the request.');
    }

    // If the original request is not empty, then illegal values are present.
    if (!empty($original_request)) {
      //$error_message = format_plural(count($original_request), 'Property @names is invalid.', 'Property @names are invalid.', array('@names' => implode(', ', array_keys($original_request))));
      //throw new \RestfulBadRequestException($error_message);
    }

    // Once the record is built, write it and view it.
    if (drupal_write_record($this->getTableName(), $record)) {
      // Handle multiple id columns.
      $id_values = array();
      foreach ($id_columns as $id_column) {
        $id_values[$id_column] = $record[$id_column];
      }
      $id = implode(self::COLUMN_IDS_SEPARATOR, $id_values);

      return $this->view($id);
    }
    return;

  }

  /**
   * Overrides RestfulDataProviderDbQuery::update().
   *
   * Verify the uer have permission to invoke this method.
   */
  public function update($id, $full_replace = FALSE) {
    $this->validate();
    return parent::update($id, $full_replace);
  }

  /**
   * Overrides RestfulDataProviderDbQuery::delete().
   *
   * Verify the uer have permission to invoke this method.
   */
  public function delete($path = '', array $request = array()) {
    $this->validate(FALSE);
    return parent::delete();
  }

  /**
   * Overrides the default validate method.
   *
   * @param bool $validate_request
   *   Determine if we need to validate the sent request values. In case of
   *   delete we don't need to validate the sent request values.
   */
  public function validate($validate_request = TRUE) {
    $this->getObject();
    $this->object->group_type = 'node';

    if (empty($this->object->gid)) {
      $this->object->gid = 0;
    }
    else {
      // Set up the space.
      spaces_set_space(vsite_get_vsite($this->object->gid));
    }

    $this->object->gid = (int) $this->object->gid;

    $this->setRequest((array) $this->object);

    if ($validate_request) {
      parent::validate();
    }

    $function = $this->object->gid ? 'og_user_access' : 'user_access';
    $params = $this->object->gid ? array('node', $this->object->gid, 'administer users', $this->getAccount()) : array('administer users', $this->getAccount());

    if (!call_user_func_array($function, $params)) {
      throw new \RestfulForbiddenException('You are not allowed to manage roles.');
    }
  }
}
