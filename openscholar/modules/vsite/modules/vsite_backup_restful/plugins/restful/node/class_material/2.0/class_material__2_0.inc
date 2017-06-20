<?php

$plugin = array(
  'label' => t('Class material'),
  'resource' => 'class_material',
  'name' => 'class_material__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'class_material',
  'description' => t('Expose class material bundle via restful'),
  'class' => 'ClassMaterialNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
