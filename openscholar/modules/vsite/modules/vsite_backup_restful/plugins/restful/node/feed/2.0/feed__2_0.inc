<?php

$plugin = array(
  'label' => t('Feed'),
  'resource' => 'feed',
  'name' => 'feed__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'feed',
  'description' => t('Expose feed bundle via restful'),
  'class' => 'FeedNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
