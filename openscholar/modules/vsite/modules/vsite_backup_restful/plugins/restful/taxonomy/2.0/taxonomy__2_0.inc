<?php

$plugin = array(
  'label' => t('Taxonomy'),
  'resource' => 'taxonomy',
  'name' => 'taxonomy__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'taxonomy_term',
  'bundle' => FALSE,
  'description' => t('Expose terms bundle via restful'),
  'class' => 'VsiteBackupTaxonomyTerm',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
