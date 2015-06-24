<?php
/**
 * @api {get} /api/files Request Site Files
 * @apiName GetFiles
 * @apiGroup File
 *
 * @apiParam {Number} vsite  Optional VSite to retrieve files from
 *
 * @apiSuccess {Object[]} files List of files in the site.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       {
 *        "id":75061,
 *        "label":"Image One",
 *        "self":"http://staging.scholar.harvard.edu/api/v1.0/files/75061",
 *        "size":"37466",
 *         "mimetype":"image/jpeg",
 *        "url":"http://staging.scholar.harvard.edu/files/rbrandon/files/cafu1.jpg",
 *        "schema":"public",
 *        "filename":"cafu1.jpg",
 *        "type":"image",
 *        "name":"Image One",
 *        "timestamp":"1360044636",
 *        "description":null,
 *        "image_alt":'alt text',
 *        "image_title":null,
 *        "preview":"
 *        img1
 *        img1 (cafu1.jpg)
 *        ",
 *        "terms":null
 *      },...
 *     }
 */

/**
 * @api {post} /api/files Save File
 * @apiName SaveFile
 * @apiGroup File
 *
 * @apiParam {Number} vsite  VSite to save the file to
 * @apiParam {Object} data  File metadat
 * @apiParam {Object} files[upload]  File Data
 *
 * @apiParamExample {multipart/form-data} Request-Example:
 *     ------WebKitFormBoundaryXgmJRlIas3M22RWQ
 *         Content-Disposition: form-data; name="vsite"
 *         2664
 *     ------WebKitFormBoundaryXgmJRlIas3M22RWQ
 *         Content-Disposition: form-data; name="data"
 *         {"lastModified":1424292767000,"lastModifiedDate":"2015-02-18T20:52:47.000Z","name":"jassleep.jpg","type":"image/jpeg","size":1967014}
 *     ------WebKitFormBoundaryXgmJRlIas3M22RWQ
 *         Content-Disposition: form-data; name="files[upload]"; filename="jassleep.jpg"
 *         Content-Type: image/jpeg
 *     ------WebKitFormBoundaryXgmJRlIas3M22RWQ--
 *
 * @apiSuccess {Object} file The saved file
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "data":[
 *          {
 *             "id":"330546",
 *             "label":"jassleep.jpg",
 *             "self":"http:\/\/staging.scholar.harvard.edu\/api\/v1.0\/files\/330546",
 *             "size":"1967014",
 *             "mimetype":"image\/jpeg",
 *             "url":"http:\/\/staging.scholar.harvard.edu\/files\/rbrandon\/files\/jassleep.jpg",
 *             "schema":"public",
 *             "filename":"jassleep.jpg",
 *             "type":"image",
 *             "name":"jassleep.jpg",
 *             "timestamp":"1431716541",
 *             "description":null,
 *             "image_alt":null,
 *             "image_title":null,
 *             "preview":"<div...preview markup",
 *             "terms":null
 *          }
 *       ],
 *       "self":{
 *          "title":"Self",
 *          "href":"http:\/\/staging.scholar.harvard.edu\/api\/v1.0\/files"
 *     }
 *}
 *
 */

/**
 * @api {patch} /api/files/:fid Update a File
 * @apiName UpdateFile
 * @apiGroup File
 *
 * @apiParam {Number} fid  A files unique ID
 * @apiParam {Object} file  File Object parameters to save
 *
 * @apiParamExample {json} Request-Example:
 *     {"name":"Jasper Sleeping","description":"My Images Description","image_alt":"Alternate TXT","image_title":"Mouseover"}
 *
 * @apiSuccess {Object} file The saved file
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "data":[
 *          {
 *             "id":"330546",
 *             "label":"jassleep.jpg",
 *             "self":"http:\/\/staging.scholar.harvard.edu\/api\/v1.0\/files\/330546",
 *             "size":"1967014",
 *             "mimetype":"image\/jpeg",
 *             "url":"http:\/\/staging.scholar.harvard.edu\/files\/rbrandon\/files\/jassleep.jpg",
 *             "schema":"public",
 *             "filename":"jassleep.jpg",
 *             "type":"image",
 *             "name":"jassleep.jpg",
 *             "timestamp":"1431716541",
 *             "description":null,
 *             "image_alt":null,
 *             "image_title":null,
 *             "preview":"<div...preview markup",
 *             "terms":null
 *          }
 *       ],
 *       "self":{
 *          "title":"Self",
 *          "href":"http:\/\/staging.scholar.harvard.edu\/api\/v1.0\/files"
 *     }
 *}
 *
 */
class OsFilesResource extends RestfulEntityBase {

  /**
   * Overrides RestfulEntityBase::publicFieldsInfo().
   */
  public function publicFieldsInfo() {
    $info = parent::publicFieldsInfo();

    $info['size'] = array(
      'property' => 'size',
      'discovery' => array(
        'data' => array(
          'type' => 'int',
          'read_only' => TRUE,
        )
      )
    );

    $info['mimetype'] = array(
      'property' => 'mime',
      'discovery' => array(
        'data' => array(
          'type' => 'string',
          'read_only' => TRUE,
        )
      )
    );

    $info['url'] = array(
      'property' => 'url',
    );

    $info['schema'] = array(
      'callback' => array($this, 'getSchema'),
    );

    $info['filename'] = array(
      'callback' => array($this, 'getFilename'),
      'saveCallback' => array($this, 'updateFileLocation')
    );

    $info['type'] = array(
      'property' => 'type',
      'discovery' => array(
        'data' => array(
          'type' => 'string',
          'read_only' => TRUE,
        )
      )
    );

    $info['name'] = array(
      'property' => 'name',
    );

    $info['timestamp'] = array(
      'property' => 'timestamp',
    );

    $info['description'] = array(
      'property' => 'os_file_description',
      'sub_property' => 'value',
      'saveCallback' => array($this, 'setDescription')
    );

    $info['image_alt'] = array(
      'property' => 'field_file_image_alt_text',
      'sub_property' => 'value',
      'callback' => array($this, 'getImageAltText'),
      'saveCallback' => array($this, 'setImageAltText'),
    );

    $info['image_title'] = array(
      'property' => 'field_file_image_title_text',
      'sub_property' => 'value',
      'callback' => array($this, 'getImageTitleText'),
      'saveCallback' => array($this, 'setImageTitleText'),
    );

    $info['preview'] = array(
      'callback' => array($this, 'getFilePreview'),
      'discovery' => array(
        'data' => array(
          'type' => 'string',
          'read_only' => TRUE,
        )
      )
    );

    $info['terms'] = array(
      'property' => OG_VOCAB_FIELD,
      'process_callbacks' => array(
        array($this, 'processTermsField'),
      ),
      'saveCallback' => array($this, 'setTerms'),
    );

    unset($info['label']['property']);

    return $info;
  }

  /**
   * Helper function for rendering a field.
   */
  private function getBundleProperty($wrapper, $field) {
    $properties = $wrapper->getPropertyInfo();

    if (isset($properties[$field])) {
      $property = $wrapper->get($field);
      return $property->value();
    }

    return null;
  }

  /**
   * Callback function to get the name of the file on disk
   * We need this to inform the user of what the new filename will be.
   */
  public function getFilename($wrapper) {
    $uri = $wrapper->value()->uri;
    return basename($uri);
  }

  /**
   * Callback function to get the schema of the file.
   * We use this to prevent user from changing the filename
   */
  public function getSchema($wrapper) {
    $uri = $wrapper->value()->uri;
    return parse_url($uri, PHP_URL_SCHEME);
  }

  /**
   * Callback function for the alt text of the image.
   */
  public function getImageAltText($wrapper) {
    return $this->getBundleProperty($wrapper, 'field_file_image_alt_text');
  }

  /**
   * Callback function for the title text.
   */
  public function getImageTitleText($wrapper) {
    return $this->getBundleProperty($wrapper, 'field_file_image_title_text');
  }

  /**
   * Callback function for the file preview.
   */
  public function getFilePreview($wrapper) {
    $output = media_get_thumbnail_preview($wrapper->value());
    return drupal_render($output);
  }

  /**
   * Override checkEntityAccess()
   */
  public function checkEntityAccess($op, $entity_type, $entity) {
    return parent::checkEntityAccess($op, $entity_type, $entity) || $this->checkGroupAccess($op, $entity);
  }

  /**
   * Check for group access
   */
  public function checkGroupAccess($op, $file = null) {
    $account = $this->getAccount();

    $vsite = null;
    if ($this->request['vsite']) {
      $vsite = $this->request['vsite'];
    }
    elseif ($file == null) {
      return FALSE;
    }
    elseif ($file instanceof EntityDrupalWrapper) {
      $value = $file->{OG_AUDIENCE_FIELD}->value();
      $vsite = $value['target_id'];
    }
    elseif (is_object($file)) {
      $vsite = $file->{OG_AUDIENCE_FIELD}[LANGUAGE_NONE][0]['target_id'];
    }

    $permission = '';
    switch ($op) {
      case 'create':
        $permission = 'create files';
        break;
      case 'update':
      case 'edit':
        $permission = 'edit any files';
        break;
      case 'delete':
        $permission = 'delete any files';
        break;
    }

    if ($permission && $vsite) {
      return og_user_access('node', $vsite, $permission, $account);
    }

    return false;
  }

  /**
   * Filter files by vsite
   */
  protected function queryForListFilter(EntityFieldQuery $query) {
    if ($this->request['vsite']) {
      if ($vsite = vsite_get_vsite($this->request['vsite'])) {
        $query->fieldCondition(OG_AUDIENCE_FIELD, 'target_id', $this->request['vsite']);
      }
      else {
        throw new RestfulBadRequestException(t('No vsite with the id @id', array('@id' => $this->request['vsite'])));
      }
    }
    // make getting private files explicit
    // private files currently require PIN authentication before they can even be access checked
    if (!isset($this->request['private'])) {
      $query->propertyCondition('uri', 'private://%', 'NOT LIKE');
    }
  }

  /**
   * Override. Handle the file upload process before creating an actual entity.
   * The file could be a straight replacement, and this is where we handle that.
   */
  public function createEntity() {
    if ($this->checkEntityAccess('create', 'file', NULL) === FALSE && $this->checkGroupAccess('create') === FALSE) {
      // User does not have access to create entity.
      $params = array('@resource' => $this->getPluginKey('label'));
      throw new RestfulForbiddenException(format_string('You do not have access to create a new @resource resource.', $params));
    }

    $destination = 'public://';
    // do spaces/private file stuff here
    if (isset($this->request['vsite'])) {
      $path = db_select('purl', 'p')->fields('p', array('value'))->condition('id', $this->request['vsite'])->execute()->fetchField();
      $destination .= $path . '/files';
    }

    $writable = file_prepare_directory($destination, FILE_MODIFY_PERMISSIONS | FILE_CREATE_DIRECTORY);

    if ($entity = file_save_upload('upload', $this->getValidators(), $destination, FILE_EXISTS_REPLACE)) {

      if (isset($this->request['vsite'])) {
        og_group('node', $this->request['vsite'], array('entity_type' => 'file', 'entity' => $entity));
        $entity = file_load($entity->fid);
      }

      if ($entity->status != FILE_STATUS_PERMANENT) {
        $entity->status = FILE_STATUS_PERMANENT;
        $entity = file_save($entity);
      }

      $wrapper = entity_metadata_wrapper($this->entityType, $entity);

      return array($this->viewEntity($wrapper->getIdentifier()));
    }
    elseif (isset($_FILES['files']) && $_FILES['files']['errors']['upload']) {
      throw new RestfulUnprocessableEntityException('Error uploading new file to server.');
    }
    elseif (isset($this->request['embed']) && module_exists('media_internet')) {

      $provider = media_internet_get_provider($this->request['embed']);
      $provider->validate();

      $validators = array();  // TODO: How do we populate this?
      $file = $provider->getFileObject();
      if ($validators) {
        $file = $provider->getFileObject();

        // Check for errors. @see media_add_upload_validate calls file_save_upload().
        // this code is ripped from file_save_upload because we just want the validation part.
        // Call the validation functions specified by this function's caller.
        $errors = array_merge($errors, file_validate($file, $validators));
      }

      if (!empty($errors)) {
        throw new MediaInternetValidationException(implode("\n", $errors));
      }
      else {
        // Providers decide if they need to save locally or somewhere else.
        // This method returns a file object
        $entity = $provider->save();

        if ($entity->status != FILE_STATUS_PERMANENT) {
          $entity->status = FILE_STATUS_PERMANENT;
          $entity = file_save($entity);
        }

        if ($this->request['vsite']) {
          og_group('node', $this->request['vsite'], array('entity_type' => 'file', 'entity' => $entity));
          $entity = file_load($entity->fid);
        }

        $wrapper = entity_metadata_wrapper($this->entityType, $entity);

        return array($this->viewEntity($wrapper->getIdentifier()));
      }
    }
    else {
      if (!$writable) {
        throw new RestfulServerConfigurationException('Unable to create directory for target file.');
      }
      else {
        // we failed for some other reason. What?
        throw new RestfulBadRequestException('Unable to process request.');
      }
    }
  }

  protected function getValidators() {
    $extensions = array();
    $types = file_type_get_enabled_types();
    foreach ($types as $t => $type) {
      $extensions = array_merge($extensions, _os_files_extensions_from_type($t));
    }

    $validators = array(
      'file_validate_extensions' => array(
        implode(' ', $extensions)
      ),
      'file_validate_size' => array(
        parse_size(file_upload_max_size())
      )
    );

    return $validators;
  }

  public function processTermsField($terms) {
    $return = array();

    foreach ($terms as $term) {
      $return[] = array(
        'id' => (int)$term->tid,
        'label' => $term->name,
        'vid' => $term->vid,
      );
    }

    return $return;
  }

  /**
   * Override. We need to handle files being replaced through this method.
   */
  public function putEntity($entity_id) {

    // this request is only a file
    // no other data is addeed
    if ($this->request['file']) {
      $oldFile = file_load($entity_id);
      $this->request['file']->filename = $oldFile->filename;
      if ($file = file_move($this->request['file'], $oldFile->uri, FILE_EXISTS_REPLACE)) {
        if ($oldFile->{OG_AUDIENCE_FIELD}) {
          og_group('node', $oldFile->{OG_AUDIENCE_FIELD}[LANGUAGE_NONE][0]['target_id'], array('entity_type' => 'file', 'entity' => $file));
        }

        return array($this->viewEntity($entity_id));
      }
      else {
        throw new RestfulBadRequestException('Error moving file.');
      }
    }

    return parent::putEntity($entity_id);
  }

  protected function setPropertyValues(EntityMetadataWrapper $wrapper, $null_missing_fields = FALSE) {
    $request = $this->getRequest();

    static::cleanRequest($request);
    $save = FALSE;
    $original_request = $request;

    foreach ($this->getPublicFields() as $public_field_name => $info) {
      if (empty($info['property']) && empty($info['saveCallback'])) {
        // We may have for example an entity with no label property, but with a
        // label callback. In that case the $info['property'] won't exist, so
        // we skip this field.
        continue;
      }

      if (isset($info['saveCallback'])) {
        $save = $save || call_user_func($info['saveCallback'], $wrapper);

        if ($save) {
          unset($original_request[$public_field_name]);
        }
      }
      elseif ($info['property']) {
        $property_name = $info['property'];

        if (!isset($request[$public_field_name])) {
          // No property to set in the request.
          if ($null_missing_fields && $this->checkPropertyAccess('edit', $public_field_name, $wrapper->{$property_name}, $wrapper)) {
            // We need to set the value to NULL.
            $wrapper->{$property_name}->set(NULL);
          }
          continue;
        }

        if (!$this->checkPropertyAccess('edit', $public_field_name, $wrapper->{$property_name}, $wrapper)) {
          throw new RestfulBadRequestException(format_string('Property @name cannot be set.', array('@name' => $public_field_name)));
        }

        $field_value = $this->propertyValuesPreprocess($property_name, $request[$public_field_name], $public_field_name);

        $wrapper->{$property_name}->set($field_value);
        unset($original_request[$public_field_name]);
        $save = TRUE;
      }
    }


    if (!$save) {
      // No request was sent.
      throw new RestfulBadRequestException('No values were sent with the request');
    }

    if ($original_request) {
      // Request had illegal values.
      $error_message = format_plural(count($original_request), 'Property @names is invalid.', 'Property @names are invalid.', array('@names' => implode(', ', array_keys($original_request))));
      throw new RestfulBadRequestException($error_message);
    }

    // Allow changing the entity just before it's saved. For example, setting
    // the author of the node entity.
    $this->entityPreSave($wrapper);

    $this->entityValidate($wrapper);

    $wrapper->save();
  }

  protected function updateFileLocation($wrapper) {
    if ($this->request['filename']) {
      $file = file_load($wrapper->getIdentifier());
      $label = $wrapper->name->value();
      $destination = dirname($file->uri) . '/' . $this->request['filename'];
      if ($file = file_move($file, $destination)) {
        $wrapper->set($file);
        $wrapper->name->set($label);
        return true;
      }
    }
    return false;
  }

  protected function setDescription($wrapper) {
    if ($this->request['description']) {
      $data = array(
        'value' => $this->request['description'],
        'format' => 'filtered_html'
      );
      $wrapper->os_file_description->set($data);

      return true;
    }
    return false;
  }

  protected function setImageAltText($wrapper) {
    if ($this->request['image_alt']) {
      $wrapper->field_file_image_alt_text->set($this->request['image_alt']);

      return true;
    }
    return false;
  }

  protected function setImageTitleText($wrapper) {
    if ($this->request['image_title']) {
      $wrapper->field_file_image_title_text->set($this->request['image_title']);

      return true;
    }
    return false;
  }

  protected function setTerms($wrapper) {
    if ($values = $this->request['terms']) {
      $terms = array();
      foreach ($values as $value) {
        foreach ($value as $term) {
          $terms[] = $term['id'];
        }
      }

      $wrapper->{OG_VOCAB_FIELD}->set($terms);

      return true;
    }
    return false;
  }
}
