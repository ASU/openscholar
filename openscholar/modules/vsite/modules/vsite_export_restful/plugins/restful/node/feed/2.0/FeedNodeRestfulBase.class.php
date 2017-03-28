<?php

class FeedNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_url'] = array(
      'property' => 'field_url',
      'required' => TRUE,
    );
    $public_fields['path'] = array(
      'property' => 'path',
    );
    $public_fields['redirect'] = array(
      'property' => 'redirect',
    );
    $public_fields['metatags'] = array(
      'property' => 'metatags',
    );
    $public_fields['og_group_ref'] = array(
      'property' => 'og_group_ref',
    );
    $public_fields['og_vocabulary'] = array(
      'property' => 'og_vocabulary',
    );
    return $public_fields;
  }

}
