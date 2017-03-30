<?php

class EventNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['start_date'] = array(
      'property' => 'field_date',
      'sub_property' => 'value',
      'process_callbacks' => array(
        array($this, 'dateProcess'),
      ),
    );

    $public_fields['end_date'] = array(
      'property' => 'field_date',
      'sub_property' => 'value2',
      'process_callbacks' => array(
        array($this, 'dateProcess'),
      ),
    );

    $public_fields['registration'] = array(
      'property' => 'registration',
      'sub_property' => 'registration_type',
    );

    $public_fields['field_event_registration'] = array(
      'property' => 'field_event_registration',
    );

    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_date'] = array(
      'property' => 'field_date',
    );
    $public_fields['field_event_location'] = array(
      'property' => 'field_event_location',
    );
    $public_fields['field_mutliple_event_signup'] = array(
      'property' => 'field_mutliple_event_signup',
    );

    return $public_fields;
  }

  public function entityPreSave(\EntityMetadataWrapper $wrapper) {
    parent::entityPreSave($wrapper);
    $request = $this->getRequest();
    $date = $wrapper->field_date->value();
    $format = 'Y-m-d h:i:s';
    if (!empty($request['start_date'])) {
      $date[0]['value'] = date($format, strtotime($request['start_date']));
    }

    $date[0]['value2'] = empty($request['end_date']) ? $date[0]['value'] : date($format, strtotime($request['end_date']));

    $wrapper->field_date->set($date);
  }
}
