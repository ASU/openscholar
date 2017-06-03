<?php

class NewsNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();


    $public_fields['title'] = array(
      'property' => 'title',
    );

    $public_fields['field_news_date'] = array(
      'property' => 'field_news_date',
      //'sub_property' => 'value',
    );
    //$public_fields['field_news_date_timezone'] = array(
    //  'property' => 'field_news_date',
    //  'sub_property' => 'timezone',
    //);
    //$public_fields['field_news_date_type'] = array(
    //  'property' => 'field_news_date',
    //  'sub_property' => 'date_type',
    //);

    $public_fields['field_photo'] = array(
      'property' => 'field_photo',
    );
    $public_fields['field_url'] = array(
      'property' => 'field_url',
    );



    return $public_fields;
  }

}
