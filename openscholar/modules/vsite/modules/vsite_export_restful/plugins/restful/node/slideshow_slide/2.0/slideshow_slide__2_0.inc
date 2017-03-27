<?php

$plugin = array(
  'label' => t('Slideshow slide'),
  'resource' => 'slideshow_slide',
  'name' => 'slideshow_slide__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'slideshow_slide',
  'description' => t('Expose slide show bundle via restful'),
  'class' => 'SlideshowSlideNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
