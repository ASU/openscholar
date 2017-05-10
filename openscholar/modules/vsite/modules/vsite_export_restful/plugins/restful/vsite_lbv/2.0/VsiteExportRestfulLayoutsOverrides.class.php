<?php

/**
 * @file
 * Contains \VsiteExportRestfulLayouts
 */

class VsiteExportRestfulLayoutsOverrides extends \VsiteExportRestfulLayouts {

  protected $validateHandler = 'layouts';
  protected $objectType = 'context';

  /**
   * Verify the user have access to the manage layout.
   */
  public function checkGroupAccess() {
// TODO Work out better access check override/logic
return TRUE;
    if (parent::checkGroupAccess()) {
      return TRUE;
    }

    $account = $this->getAccount();

    if (!spaces_access_admin($account, $this->space)) {
      // The current user can't manage boxes.
      $this->throwException("You can't manage layout in this vsite.");
    }

    return true;
  }

  /**
   * Updating a given layout.
   *
   * type: PUT
   * values: {
   *  vsite: 2,
   *  object_id: os_pages-page-581,
   *  blocks: [
   *    os_search_db-site-search: [
   *      region: "sidebar_first"
   *    ]
   *  ]
   * }
   */
  public function updateLayout() {
    // Check group access.
    $this->checkGroupAccess();

    // Validate the object from the request.
    $this->validate();

    // Set up the blocks layout.
    ctools_include('layout', 'os');

// TODO layout field/object mapping
    $blocks = os_layout_get($this->object->object_id, FALSE, FALSE, $this->space);

    foreach ($blocks as $delta => $block) {
      if (empty($this->object->blocks[$delta])) {
        continue;
      }
      $blocks[$delta] = array_merge($blocks[$delta], $this->object->blocks[$delta]);
    }

    os_layout_set($this->object->object_id, $blocks, $this->space);

    return $blocks;
  }

  /**
   * Creating a vsite layout.
   *
   * type: POST
   * values: {
   *  vsite: 2,
   *  object_id: os_pages-page-581,
   *  boxes: [
   *    boxes-1419335380: [
   *      module: "boxes",
   *      delta: "1419335380",
   *      region: "sidebar_second",
   *      weight: 2,
   *      status: 0
   *    ]
   *  ]
   * }
   */
  public function createLayout() {

    // Check group access.
    $this->checkGroupAccess();

    // Validate the object from the request.
    $this->validate();

    // Save the blocks layout.

    ctools_include('layout', 'os');

    foreach ($this->request as $context_name => $layout) {

      if (is_array($layout)) {

        foreach ($layout as $key => $block) {

          drupal_write_record('vsite_layout_block', $block);

        }
      }
    }

    return TRUE;
  }

  /**
   * In order to delete the layout override pass the next arguments:
   *
   * type: DELETE
   * values: {
   *  vsite: 2,
   *  object_id: os_pages-page-582:reaction:block,
   *  delta: boxes-1419335380
   * }
   */
  public function deleteLayout() {

    // Check group access.
    $this->checkGroupAccess();

    db_delete('vsite_layout_block')
      ->condition('sid', $this->request['vsite']['sid'])
      //->condition('sd', $this->object->object_id)
      //->condition('id', $this->object->vsite)
      ->execute();
  }

  /**
   * In order to get the layout override pass the next arguments:
   *
   * type: GET
   * values: {
   *  vsite: 2
   * }
   */
  public function getLayout() {

    // Check group access.
    $this->checkGroupAccess();


    $layouts = [];
    if($this->request['vsite']['sid'] && is_numeric($this->request['vsite']['sid'])){

      /*
      $vlb = db_select('vsite_layout_block', 'v')
        ->condition('v.sid', $this->request['vsite']['sid'], '=')
        ->fields('v', array('delta', 'context', 'module', 'region', 'weight'))
        ->execute();

      $layouts['vsite_layout_block'] = $vlb->fetchAll();
      */

      ctools_include('layout', 'os');

      $contexts = os_layout_get_contexts($privacy = array(1, 2), $user_created = TRUE);

      $vsite_id = $this->request['vsite']['sid'];
      $vsite_space =  spaces_load($type = 'og', $vsite_id, $reset = TRUE);

      $layouts['vsite_layout_block'] = array();
      foreach ($contexts as $context_name => $context_value) {
        $layouts['vsite_layout_block'][$context_name] = os_layout_get($context_name, $load_meta = FALSE, $unused_blocks = FALSE, $space = $vsite_space);
        // Add in the bits needed for vsite_layout_block records.
        foreach ($layouts['vsite_layout_block'][$context_name] as $k => $v) {
          $layouts['vsite_layout_block'][$context_name][$k]['sid'] = $vsite_id;
          $layouts['vsite_layout_block'][$context_name][$k]['context'] = $context_name;
        }
      }

      if (sizeof($layouts['vsite_layout_block']) > 0){
        return $layouts;
      } else {
        watchdog('vsite_export', t('Empty Layout configuration in export request for Vsite @vsite'), array('@vsite' => $this->object->vsite));
        return array();
      }
    } else {
      watchdog('vsite_export', t('Vsite Export RESTful endpoint receiving non-integer Vsite ID'));
      return array();
    }

  }
}
