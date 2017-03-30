<?php

class ClassNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

        $public_fields['title'] = array(
          'property' => 'title',
        );
        $public_fields['field_semester'] = array(
          'property' => 'field_semester',
        );
        $public_fields['field_offered_year'] = array(
          'property' => 'field_offered_year',
        );
        $public_fields['field_class_link'] = array(
          'property' => 'field_class_link',
        );
        $public_fields['field_weight'] = array(
          'property' => 'field_weight',
        );

    return $public_fields;
  }
}
