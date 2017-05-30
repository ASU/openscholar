<?php

/**
 * Implement hook_views_data().
 */
function vsite_backup_views_data(){

  $data = array();

  $data['vsite_backup_exports']['table']['group'] = t("Vsite Backup Exports");

  $data['vsite_backup_exports']['table']['base'] = array(
    'field' => 'eid', // This is the identifier field for the view.
    'title' => t('Vsite Backup Exports'),
    'help' => t('Example table contains example content and can be related to nodes.'),
    'weight' => -10,
  );

  $data['vsite_backup_exports']['eid'] = array(
    'title' => t('Export ID'),
    'help' => t('The ID of the export on the Openscholar deployment'),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => FALSE,
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
  );
  $data['vsite_backup_exports']['vsite_id'] = array(
    'title' => t('Vsite ID'),
    'help' => t('The ID of the exported vsite on the Openscholar deployment'),
    'field' => array(
      'handler' => 'views_handler_field_numeric',
      'click sortable' => FALSE,
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_numeric',
    ),
  );


  $data['vsite_backup_exports']['status'] = array(
    'title' => t('Status'),
    'help' => t('The status of the export. Complete/In Progress'),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => FALSE,
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
  );

  $data['vsite_backup_exports']['fid'] = array(
    'title' => t('File ID'),
    'help' => t('The file ID of the exportable in relation to this item'),
    'field' => array(
      'handler' => 'views_handler_field_markup',
      'format' => 'full_html', // filtered_html, plain_text etc.
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
  );

  $data['vsite_backup_exports']['uid'] = array(
    'title' => t('User ID'),
    'help' => t('The ID of the user exporting on the Openscholar deployment'),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => FALSE,
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
  );

  $data['vsite_backup_exports']['created'] = array(
    'title' => t('Created Timestamp'),
    'help' => t('The time that the export started'),
    'field' => array(
      'handler' => 'views_handler_field_date',
      'click sortable' => TRUE,
    ),
    'sort' => array(
      'handler' => 'views_handler_sort_date',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_date',
    ),
  );

  return $data;

}