<?php

/**
 * Implements hook_views_default_views().
 */
function vsite_backup_views_default_views(){
  $view = new view();
  $view->name = 'vsite_backup_exports';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'vsite_backup_exports';
  $view->human_name = 'Vsite Backup Exports';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Vsite Backup Exports';
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '10';
  $handler->display->display_options['style_plugin'] = 'table';
  $handler->display->display_options['style_options']['columns'] = array(
    'eid' => 'eid',
    'created' => 'created',
    'eid_1' => 'eid_1',
    'fid' => 'fid',
    'status' => 'status',
    'uid' => 'uid',
    'vsite_id' => 'vsite_id',
  );
  $handler->display->display_options['style_options']['default'] = '-1';
  $handler->display->display_options['style_options']['info'] = array(
    'eid' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'created' => array(
      'sortable' => 0,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'eid_1' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'fid' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'status' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'uid' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'vsite_id' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
  );
  /* Field: Vsite Backup Exports: Vsite ID */
  $handler->display->display_options['fields']['vsite_id']['id'] = 'vsite_id';
  $handler->display->display_options['fields']['vsite_id']['table'] = 'vsite_backup_exports';
  $handler->display->display_options['fields']['vsite_id']['field'] = 'vsite_id';
  /* Field: Vsite Backup Exports: Export ID */
  $handler->display->display_options['fields']['eid']['id'] = 'eid';
  $handler->display->display_options['fields']['eid']['table'] = 'vsite_backup_exports';
  $handler->display->display_options['fields']['eid']['field'] = 'eid';
  /* Field: Vsite Backup Exports: Created Timestamp */
  $handler->display->display_options['fields']['created']['id'] = 'created';
  $handler->display->display_options['fields']['created']['table'] = 'vsite_backup_exports';
  $handler->display->display_options['fields']['created']['field'] = 'created';
  $handler->display->display_options['fields']['created']['label'] = 'Export Created';
  $handler->display->display_options['fields']['created']['date_format'] = 'os_time';
  $handler->display->display_options['fields']['created']['second_date_format'] = 'os_time';
  /* Field: Vsite Backup Exports: File ID */
  $handler->display->display_options['fields']['fid']['id'] = 'fid';
  $handler->display->display_options['fields']['fid']['table'] = 'vsite_backup_exports';
  $handler->display->display_options['fields']['fid']['field'] = 'fid';
  /* Field: Vsite Backup Exports: Status */
  $handler->display->display_options['fields']['status']['id'] = 'status';
  $handler->display->display_options['fields']['status']['table'] = 'vsite_backup_exports';
  $handler->display->display_options['fields']['status']['field'] = 'status';

  /* Display: Page */
  $handler = $view->new_display('page', 'Page', 'page');
  $handler->display->display_options['path'] = 'vsite-backup-exports';

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block');
  $handler->display->display_options['defaults']['pager'] = FALSE;
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '5';


}