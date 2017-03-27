<?php

$plugin = array(
  'label' => t('Presentation'),
  'resource' => 'presentation',
  'name' => 'presentation__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'presentation',
  'description' => t('Expose presentation bundle via restful'),
  'class' => 'PresentationNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
