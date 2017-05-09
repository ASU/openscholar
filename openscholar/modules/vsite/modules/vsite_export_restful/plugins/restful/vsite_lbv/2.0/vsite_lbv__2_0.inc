<?php

$plugin = array(
  'label' => t('vsite lbv'),
  'description' => t('End point for vsite layout, boxes, variables.'),
  'resource' => 'layouts',
  'major_version' => 2,
  'minor_version' => 0,
  'class' => 'VsiteExportRestfulLayoutsOverrides',

  'data_provider_options' => array(
    'table_name' => 'vsite_layout_block',
    'id_column' => array('sid', 'delta', 'module', 'context'),
  ),

  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
  'hook_menu' => TRUE,
);
