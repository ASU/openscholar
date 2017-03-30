<?php

class NewsNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();


    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_news_date'] = array(
      'property' => 'field_news_date',
    );
    $public_fields['field_photo'] = array(
      'property' => 'field_photo',
    );
    $public_fields['field_url'] = array(
      'property' => 'field_url',
    );



    return $public_fields;
  }

}
