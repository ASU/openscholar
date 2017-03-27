<?php

$plugin = array(
  'label' => t('OG vocab'),
  'resource' => 'og_vocab',
  'name' => 'og_vocab__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'og_vocab',
  'bundle' => FALSE,
  'description' => t('Expose OG vocabulary via restful'),
  'class' => 'VsiteExportOgVocab',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
