<?php

$plugin = array(
  'label' => t('page'),
  'resource' => 'page',
  'name' => 'page__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'page',
  'description' => t('Expose page bundle via restful'),
  'class' => 'PageNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
