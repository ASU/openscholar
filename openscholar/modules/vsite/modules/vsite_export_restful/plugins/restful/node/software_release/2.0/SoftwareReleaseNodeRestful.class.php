<?php

class SoftwareReleaseNodeRestful extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['software_project'] = array(
      'property' => 'field_software_project',
      'process_callbacks' => array(
        array($this, 'softwareProjectPreprocess'),
      ),
    );


    $public_fields['field_software_version'] = array(
      'property' => 'field_software_version',
    );

    $public_fields['field_software_package'] = array(
      'property' => 'field_software_package',
      'process_callbacks' => array(
        array($this, 'singleFileFieldDisplay'),
      ),
    );

    $public_fields['field_software_recommended'] = array(
      'property' => 'field_software_recommended',
      'process_callbacks' => array(
        array($this, 'softwareProjectRecommended'),
      ),
    );


    return $public_fields;
  }

  /**
   * Return the project name and id.
   */
  public function softwareProjectPreprocess($value) {
    return array(
      'id' => $value->nid,
      'label' => $value->title,
    );
  }

  public function softwareProjectRecommended($value) {
    return $value ? t('Recommended') : t('Not Recommended');
  }

}
