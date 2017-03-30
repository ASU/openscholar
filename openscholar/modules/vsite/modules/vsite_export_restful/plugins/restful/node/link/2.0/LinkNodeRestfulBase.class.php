<?php

class LinkNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['url'] = array(
      'property' => 'field_links_link',
      'sub_property' => 'url',

    );

    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_open_link_in_new_tab'] = array(
      'property' => 'field_open_link_in_new_tab',
    );

    return $public_fields;
  }

}
