<?php

$plugin = array(
  'label' => t('Roles'),
  'description' => t('Export the "Roles" table.'),
  'resource' => 'roles',
  'class' => 'VsiteExportRestfulRoles',
  'data_provider_options' => array(
    'table_name' => 'og_role',
    'id_column' => 'rid',
  ),
  'authentication_types' => TRUE,
  'authentication_optional' => TRUE,
);
