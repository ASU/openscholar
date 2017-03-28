<?php

class SoftwareProjectNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();



    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_software_method'] = array(
      'property' => 'field_software_method',
    );
    $public_fields['path'] = array(
      'property' => 'path',
    );
    $public_fields['redirect'] = array(
      'property' => 'redirect',
    );
    $public_fields['field_upload'] = array(
      'property' => 'field_upload',
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
