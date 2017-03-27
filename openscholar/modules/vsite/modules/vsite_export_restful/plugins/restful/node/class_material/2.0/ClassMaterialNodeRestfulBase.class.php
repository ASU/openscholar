<?php

class ClassMaterialNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['parent'] = array(
      'property' => 'field_class',
    );

    return $public_fields;
  }

}
