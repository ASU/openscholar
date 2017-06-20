<?php

$plugin = array(
  'label' => t('Software project'),
  'resource' => 'software_project',
  'name' => 'software_project__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'software_project',
  'description' => t('Expose software project bundle via restful'),
  'class' => 'SoftwareProjectNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
