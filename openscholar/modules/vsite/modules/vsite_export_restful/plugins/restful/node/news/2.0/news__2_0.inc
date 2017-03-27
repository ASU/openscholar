<?php

$plugin = array(
  'label' => t('News'),
  'resource' => 'news',
  'name' => 'news__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'news',
  'description' => t('Expose news bundle via restful'),
  'class' => 'NewsNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
