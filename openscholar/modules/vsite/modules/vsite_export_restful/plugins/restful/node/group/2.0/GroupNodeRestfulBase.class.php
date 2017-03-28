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
    $public_fields['path'] = array(
      'property' => 'path',
    );
    $public_fields['redirect'] = array(
      'property' => 'redirect',
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
    $public_fields['metatags'] = array(
      'property' => 'metatags',
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

    $query->propertyCondition('type', array('personal', 'project', 'department'), 'IN');
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

    parent::setPropertyValues($wrapper, $null_missing_fields);
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
}
