<?php

$plugin = array(
  'label' => t('Group'),
  'resource' => 'group',
  'name' => 'group__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => FALSE,
  'description' => t('Expose group bundle via restful'),
  'class' => 'GroupNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
