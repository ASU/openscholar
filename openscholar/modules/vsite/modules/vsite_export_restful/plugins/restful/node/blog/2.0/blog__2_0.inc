<?php

$plugin = array(
  'label' => t('Blog'),
  'resource' => 'blog',
  'name' => 'blog__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'blog',
  'description' => t('Expose blog bundle via restufl'),
  'class' => 'BlogNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
