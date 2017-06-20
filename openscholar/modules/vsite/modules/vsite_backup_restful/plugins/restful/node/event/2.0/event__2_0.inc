<?php

$plugin = array(
  'label' => t('Event'),
  'resource' => 'event',
  'name' => 'event__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'event',
  'description' => t('Expose event bundle via restful'),
  'class' => 'EventNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
