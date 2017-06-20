<?php

$plugin = array(
  'label' => t('FAQ'),
  'resource' => 'faq',
  'name' => 'faq__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'faq',
  'description' => t('Expose faq bundle via restful'),
  'class' => 'FAQNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
