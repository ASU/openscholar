<?php

class PersonNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();


    $public_fields['field_prefix'] = array(
      'property' => 'field_prefix',
    );
    $public_fields['field_first_name'] = array(
      'property' => 'field_first_name',
    );
    $public_fields['field_middle_name_or_initial'] = array(
      'property' => 'field_middle_name_or_initial',
    );
    $public_fields['field_last_name'] = array(
      'property' => 'field_last_name',
    );
    $public_fields['field_professional_title'] = array(
      'property' => 'field_professional_title',
    );
    $public_fields['field_address'] = array(
      'property' => 'field_address',
    );
    $public_fields['field_phone'] = array(
      'property' => 'field_phone',
    );
    $public_fields['field_child_site'] = array(
      'property' => 'field_child_site',
    );
    $public_fields['field_office_hours'] = array(
      'property' => 'field_office_hours',
    );
    $public_fields['field_email'] = array(
      'property' => 'field_email',
    );
    $public_fields['field_website'] = array(
      'property' => 'field_website',
    );
    $public_fields['field_person_photo'] = array(
      'property' => 'field_person_photo',
    );
    $public_fields['field_url'] = array(
      'property' => 'field_url',
    );
    $public_fields['field_destination_url'] = array(
      'property' => 'field_destination_url',
    );
    $public_fields['field_uuid'] = array(
      'property' => 'field_uuid',
    );
    $public_fields['field_original_destination_url'] = array(
      'property' => 'field_original_destination_url',
    );


    return $public_fields;
  }

}
