<?php

class PresentationNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['path'] = array(
      'property' => 'path',
    );
    $public_fields['redirect'] = array(
      'property' => 'redirect',
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
