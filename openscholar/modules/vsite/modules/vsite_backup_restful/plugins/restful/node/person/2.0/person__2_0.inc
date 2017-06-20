<?php

$plugin = array(
  'label' => t('Person'),
  'resource' => 'person',
  'name' => 'person__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'person',
  'description' => t('Expose presentation bundle via restful'),
  'class' => 'PersonNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
