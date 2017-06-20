<?php

class ClassMaterialNodeRestfulBase extends VsiteBackupNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

        $public_fields['title'] = array(
          'property' => 'title',
        );
        $public_fields['field_class'] = array(
          'property' => 'field_class',
        );

    return $public_fields;
  }
}
