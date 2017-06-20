<?php

class SoftwareProjectNodeRestfulBase extends VsiteBackupNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();


    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_software_method'] = array(
      'property' => 'field_software_method',
    );

    return $public_fields;
  }

}
