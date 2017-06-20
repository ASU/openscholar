<?php
$plugin = array(
  'label' => t('Profiles'),
  'resource' => 'profiles',
  'name' => 'profiles__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'person',
  'description' => t('Expose the profile content type.'),
  'class' => 'VsiteBackupProfilesResource',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
