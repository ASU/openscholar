<?php

$plugin = array(
  'label' => t('Bio'),
  'resource' => 'bio',
  'name' => 'bio__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'bio',
  'description' => t('Expose bio bundle via restufl'),
  'class' => 'BioNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
