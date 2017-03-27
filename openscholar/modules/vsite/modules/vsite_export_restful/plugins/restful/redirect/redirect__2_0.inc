<?php

$plugin = array(
  'label' => t('Redirects'),
  'description' => t('End point for redirects'),
  'resource' => 'redirect',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'redirect',
  'class' => 'VsiteExportRestfulRedirect',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
  'hook_menu' => TRUE,
);