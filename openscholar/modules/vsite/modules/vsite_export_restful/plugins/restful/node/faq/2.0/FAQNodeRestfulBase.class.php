<?php

class FAQNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['title'] = array(
      'property' => 'title',
    );

    return $public_fields;
  }

}
