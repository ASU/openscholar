<?php

$plugin = array(
  'label' => t('Software release'),
  'resource' => 'software_release',
  'name' => 'software_release__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'software_release',
  'description' => t('Expose software release bundle via restful'),
  'class' => 'SoftwareReleaseNodeRestful',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
