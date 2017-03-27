<?php

class LinkNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['url'] = array(
      'property' => 'field_links_link',
      'sub_property' => 'url',

    );

    return $public_fields;
  }

}
