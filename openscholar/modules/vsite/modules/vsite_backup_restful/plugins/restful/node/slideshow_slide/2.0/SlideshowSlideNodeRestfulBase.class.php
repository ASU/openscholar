<?php

class SlideshowSlideNodeRestfulBase extends VsiteBackupNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();


    $public_fields['title'] = array(
      'property' => 'title',
    );
    $public_fields['field_image'] = array(
      'property' => 'field_image',
    );
    $public_fields['field_link'] = array(
      'property' => 'field_link',
    );
    $public_fields['field_headline'] = array(
      'property' => 'field_headline',
    );
    $public_fields['field_description'] = array(
      'property' => 'field_description',
    );
    $public_fields['field_slideshow_alt_text'] = array(
      'property' => 'field_slideshow_alt_text',
    );
    $public_fields['field_slideshow_title_text'] = array(
      'property' => 'field_slideshow_title_text',
    );


    return $public_fields;
  }

}
