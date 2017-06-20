<?php

$plugin = array(
  'label' => t('Biblio'),
  'resource' => 'biblio',
  'name' => 'biblio__2_0',
  'major_version' => 2,
  'minor_version' => 0,
  'entity_type' => 'node',
  'bundle' => 'biblio',
  'description' => t('Expose biblio bundle via restufl'),
  'class' => 'BiblioNodeRestfulBase',
  'authentication_types' => TRUE,
  'authentication_optional' => FALSE,
  'discoverable' => FALSE,
);
