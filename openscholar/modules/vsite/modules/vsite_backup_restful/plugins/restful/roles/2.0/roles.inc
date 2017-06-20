<?php

$plugin = array(
  'label' => t('Roles'),
  'description' => t('Export the "Roles" table.'),
  'resource' => 'roles',
  'major_version' => 2,
  'minor_version' => 0,
  'class' => 'VsiteBackupRestfulRoles',
  'data_provider_options' => array(
    'table_name' => 'og_role',
    'id_column' => 'rid',
  ),
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
