<?php

class PresentationNodeRestfulBase extends VsiteBackupNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_presentation_date'] = array(
      'property' => 'field_presentation_date',
      'process_callbacks' => array(
        array($this, 'dateProcess'),
      ),
    );
    $public_fields['field_presentation_location'] = array(
      'property' => 'field_presentation_location',
    );
    $public_fields['field_presentation_file'] = array(
      'property' => 'field_presentation_file',
    );

    return $public_fields;
  }

}
