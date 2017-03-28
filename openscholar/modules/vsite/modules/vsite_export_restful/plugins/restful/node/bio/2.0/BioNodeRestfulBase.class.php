<?php

class BioNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    /*
        $public_fields[''] = array(
          'property' => '',
          //'sub_property' => 'name',
          //'process_callbacks' => array(
          //  array($this, 'myProvidedValueCallback'),
          //),
          //'resource' => array( // sub request/reference - see docs/api_drupal.md
          //  'tags' => 'tags',
          //),
        );

        $public_fields[''] = array(
          'property' => '',
        );
    */


    // TODO in site using this feature.


    return $public_fields;
  }
}
