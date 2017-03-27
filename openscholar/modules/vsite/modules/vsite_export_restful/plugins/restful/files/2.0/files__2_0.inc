<?php

$plugin = array(
  'label' => t('Files'),
  'resource' => 'files',
  'name' => 'files__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'file',
  'description' => t('Export the file entity type.'),
  'class' => 'VsiteExportFilesResource',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
