<?php
$plugin = array(
  'label' => t('Users'),
  'description' => t('Export the "User" entity.'),
  'resource' => 'users',
  'name' => 'users__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'class' => 'VsiteBackupRestfulUser',
  'entity_type' => 'user',
  'bundle' => 'user',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
