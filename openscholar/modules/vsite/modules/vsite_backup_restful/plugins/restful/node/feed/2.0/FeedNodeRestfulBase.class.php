<?php

class FeedNodeRestfulBase extends VsiteBackupNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_url'] = array(
      'property' => 'field_url',
      'required' => TRUE,
    );

    return $public_fields;
  }




  /**
   * Determine if an entity is valid, and accessible.
   *
   * @param $op
   *   The operation to perform on the entity (view, update, delete).
   * @param $entity_id
   *   The entity ID.
   *
   * @return bool
   *   TRUE if entity is valid, and user can access it.
   *
   * @throws RestfulUnprocessableEntityException
   * @throws RestfulForbiddenException
   */
  protected function isValidEntity($op, $entity_id) {
    $entity_type = $this->entityType;

    $params = array(
      '@id' => $entity_id,
      '@resource' => $this->getPluginKey('label'),
    );

    if (!$entity = entity_load_single($entity_type, $entity_id)) {
      throw new RestfulUnprocessableEntityException(format_string('The entity ID @id for @resource does not exist.', $params));
    }

    list(,, $bundle) = entity_extract_ids($entity_type, $entity);

    $resource_bundle = $this->getBundle();
    if ($resource_bundle && $bundle != $resource_bundle) {
      throw new RestfulUnprocessableEntityException(format_string('The entity ID @id is not a valid @resource.', $params));
    }

    /* Comment this out to avoid errors thrown during export process.
    // TODO Confirm this doesn't have adverse security implications.

    if ($this->checkEntityAccess($op, $entity_type, $entity) === FALSE) {

      if ($op == 'view' && !$this->getPath()) {
        // Just return FALSE, without an exception, for example when a list of
        // entities is requested, and we don't want to fail all the list because
        // of a single item without access.
        return FALSE;
      }

      // Entity was explicitly requested so we need to throw an exception.
      throw new RestfulForbiddenException(format_string('You do not have access to entity ID @id of resource @resource', $params));
    }
    */

    return TRUE;
  }




}
