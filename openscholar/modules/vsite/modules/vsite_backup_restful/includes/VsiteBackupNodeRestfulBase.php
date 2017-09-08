<?php

class VsiteBackupNodeRestfulBase extends RestfulEntityBaseNode {

  /**
   * Overrides \RestfulDataProviderEFQ::controllersInfo().
   */
  public static function controllersInfo() {
    return array(
      '' => array(
        \RestfulInterface::GET => 'getList',
        \RestfulInterface::HEAD => 'getList',
        \RestfulInterface::POST => 'createEntity',
        \RestfulInterface::DELETE => 'deleteEntity',
      ),
      '^(\d+,)*\d+$' => array(
        \RestfulInterface::GET => 'viewEntities',
        \RestfulInterface::HEAD => 'viewEntities',
        \RestfulInterface::PUT => 'putEntity',
        \RestfulInterface::PATCH => 'patchEntity',
        \RestfulInterface::DELETE => 'deleteEntity',
      ),
    );
  }

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    if ($this->getBundle()) {
      $public_fields['vsite'] = array(
        'property' => OG_AUDIENCE_FIELD,
        'process_callbacks' => array(
          array($this, 'vsiteFieldDisplay'),
        ),
      );
    }

    $public_fields['body'] = array(
      'property' => 'body',
      'sub_property' => 'value',
    );

    $public_fields['type'] = array(
      'property' => 'type',
    );

    if (field_info_instance($this->getEntityType(), 'field_upload', $this->getBundle())) {
      $public_fields['field_upload'] = array(
        'property' => 'field_upload',
        'process_callbacks' => array(
          array($this, 'fileFieldDisplay'),
        ),
      );
    }


    if (field_info_instance($this->getEntityType(), 'path', $this->getBundle())) {
      $public_fields['path'] = array(
        'property' => 'path',
      );
    }
    if (field_info_instance($this->getEntityType(), 'og_group_ref', $this->getBundle())) {
      $public_fields['og_group_ref'] = array(
        'property' => 'og_group_ref',
      );
    }
    if (field_info_instance($this->getEntityType(), 'og_vocabulary', $this->getBundle())) {
      $public_fields['og_vocabulary'] = array(
        'property' => 'og_vocabulary',
      );
    }

    return $public_fields;
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

  /**
   * Display the id and the title of the group.
   */
  public function vsiteFieldDisplay($value) {
    return array('title' => $value[0]->title, 'id' => $value[0]->nid);
  }

  /**
   * Process the time stamp to a text.
   */
  public function dateProcess($value) {
    return format_date($value[0]);
  }

  /**
   * Process the file field.
   */
  public function fileFieldDisplay($files) {
    $return = array();

    foreach ($files as $file) {
      $return[] = array(
        'fid' => $file['fid'],
        'filemime' => $file['filemime'],
        'name' => $file['filename'],
        'uri' => $file['uri'],
        'url' => file_create_url($file['uri']),
      );
    }

    return $return;
  }

  public function propertyValuesPreprocess($property_name, $value, $public_field_name) {

    $field_info = field_info_field($property_name);
    switch ($field_info['type']) {
      case 'datetime':
      case 'datestamp':
        return $this->handleDatePopulation($public_field_name, $value);
      case 'link_field':
        return array('url' => $value);
      default:
        return parent::propertyValuesPreprocess($property_name, $value, $public_field_name);
    }
  }

  private function handleDatePopulation($public_field_name, $value) {
    if (in_array($this->getBundle(), array('presentation', 'news'))) {
      return strtotime($value);
    }
    else {
      return array(array($this->publicFields[$public_field_name]['sub_property'] => ''));
    }
  }

  public function singleFileFieldDisplay($file) {
    return $this->fileFieldDisplay(array($file));
  }

}
