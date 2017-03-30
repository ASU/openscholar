<?php

class PageNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();


    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_meta_description'] = array(
      'property' => 'field_meta_description',
    );


    return $public_fields;
  }

}
