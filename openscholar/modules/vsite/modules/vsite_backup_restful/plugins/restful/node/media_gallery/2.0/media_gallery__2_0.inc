<?php

$plugin = array(
  'label' => t('Media gallery'),
  'resource' => 'media_gallery',
  'name' => 'media_gallery__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'media_gallery',
  'description' => t('Expose media gallery bundle via restful'),
  'class' => 'MediaGalleryNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
