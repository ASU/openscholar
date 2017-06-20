<?php

$plugin = array(
  'label' => t('Vocabulary'),
  'resource' => 'vocabulary',
  'name' => 'vocabulary__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'taxonomy_vocabulary',
  'bundle' => FALSE,
  'description' => t('Expose vocabularies via restful'),
  'class' => 'VsiteBackupVocabulary',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
