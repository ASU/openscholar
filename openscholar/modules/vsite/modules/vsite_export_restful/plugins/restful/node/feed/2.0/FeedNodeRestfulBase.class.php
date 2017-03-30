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

    return $public_fields;
  }

}
