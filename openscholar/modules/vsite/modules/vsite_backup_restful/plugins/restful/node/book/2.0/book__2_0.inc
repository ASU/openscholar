<?php

$plugin = array(
  'label' => t('Book'),
  'resource' => 'book',
  'name' => 'book__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'book',
  'description' => t('Expose book bundle via restful'),
  'class' => 'BookNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
