<?php

$plugin = array(
  'label' => t('Link'),
  'resource' => 'link',
  'name' => 'link__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'link',
  'description' => t('Expose link bundle via restful'),
  'class' => 'LinkNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
