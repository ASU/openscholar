<?php

$plugin = array(
  'label' => t('CV'),
  'resource' => 'cv',
  'name' => 'cv__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'cv',
  'description' => t('Expose CV bundle via restufl'),
  'class' => 'CVNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
