<?php

$plugin = array(
  'label' => t('vsite lbv'),
  'description' => t('End point for vsite layout, boxes, variables.'),
  'resource' => 'layouts',
  'major_version' => 2,
  'minor_version' => 0,
  'class' => 'VsiteExportRestfulLayout',
  'data_provider_options' => array(
    'table_name' => 'spaces_overrides',
    'id_column' => array('object_type', 'object_id', 'id'),
  ),
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
  'hook_menu' => TRUE,
);
