<?php

/**
 * @file
 * Contains \VsiteExportRestfulSpaces
 */

class VsiteExportRestfulSpacesOverrides extends \VsiteExportRestfulSpaces {

  protected $validateHandler = 'layouts';
  protected $objectType = 'context';

  /**
   * Verify the user have access to the manage layout.
   */
  public function checkGroupAccess() {
    if (parent::checkGroupAccess()) {
      return TRUE;
    }

    // Allow for exports.
    $method = $this->getMethod();
    // For GET method, allow access based on backup perm.
    if ($method == \RestfulBase::GET) {
      return vsite_og_user_access('access vsite backup');
    }

    $account = $this->getAccount();

    if (!spaces_access_admin($account, $this->space)) {
      // The current user can't manage boxes.
      $this->throwException("You can't manage layout in this vsite.");
    }

    return true;
  }

  /**
   * Updating a given space override.
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
  public function updateSpace() {
    // Check group access.
    $this->checkGroupAccess();

    // Validate the object from the request.
    $this->validate();

    // Set up the blocks layout.
    ctools_include('layout', 'os');

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
   * Creating a space override.
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
  public function createSpace() {
    // Check group access.
// TODO  use this resolution to access check for all import resources? or use their method... or?
//    $this->checkGroupAccess();

    // Validate the object from the request.
    $this->validate();

    ctools_include('layout', 'os');

    $id = $this->request['vsite'];

    foreach ($this->request as $name => $overrides) {

      //if (is_array($overrides)) {

        $overrides['type'] = 'og';
        $overrides['id'] = $id;

        drupal_write_record('spaces_overrides', $overrides);

      //}
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
  public function deleteSpace() {
    // Check group access.
    $this->checkGroupAccess();

    db_delete('spaces_overrides')
      ->condition('object_id', $this->object->object_id)
      ->condition('id', $this->object->vsite)
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
  public function getSpace() {
    // Check group access.
    $this->checkGroupAccess();

    $layouts = [];

    if($this->object->vsite && is_numeric($this->object->vsite)){
      $spaces = db_select('spaces_overrides', 's')
        ->condition('s.id', $this->object->vsite, '=')
        ->fields('s',array('value', 'object_id', 'object_type', 'id', 'type'))
        ->execute();
      $layouts['spaces_overrides'] = $spaces->fetchAll();

      if(sizeof($layouts['spaces_overrides']) > 0){
        return $layouts;
      } else {
        watchdog('vsite_export', 'Empty Space/Layout configuration in export request for Vsite ' . $this->object->vsite);
        return array();
      }

    } else {
      watchdog('vsite_export', 'Vsite Export RESTful endpoint receiving non-integer vsite ID');
      return array();
    }

  }
}
