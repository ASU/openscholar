<?php

class MediaGalleryNodeRestfulBase extends VsiteExportNodeRestfulBase {

  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    // Body field Isn't attached.
    unset($public_fields['body']);


    $public_fields['title'] = array(
      'property' => 'title',
    );

    $public_fields['media_gallery_description'] = array(
      'property' => 'media_gallery_description',
      'sub_property' => 'value',
    );
    $public_fields['media_gallery_description_format'] = array(
      'property' => 'media_gallery_description',
      'sub_property' => 'format',
    );
    $public_fields['media_gallery_format'] = array(
      'property' => 'media_gallery_format',
      //'sub_property' => 'value',
    );
    $public_fields['media_gallery_file'] = array(
      'property' => 'media_gallery_file',
      //'sub_property' => 'fid',
    );
    /*
    $public_fields['media_gallery_file_fid'] = array(
      'property' => 'media_gallery_file',
      'sub_property' => 'fid',
    );
    $public_fields['media_gallery_file_display'] = array(
      'property' => 'media_gallery_file',
      'sub_property' => 'display',
    );
    $public_fields['media_gallery_file_description'] = array(
      'property' => 'media_gallery_file',
      'sub_property' => 'description',
    );
    */

    $public_fields['media_gallery_lightbox_extras'] = array(
      'property' => 'media_gallery_lightbox_extras',
    );
    $public_fields['media_gallery_columns'] = array(
      'property' => 'media_gallery_columns',
    );
    $public_fields['media_gallery_rows'] = array(
      'property' => 'media_gallery_rows',
    );
    $public_fields['media_gallery_image_info_where'] = array(
      'property' => 'media_gallery_image_info_where',
    );
    $public_fields['media_gallery_allow_download'] = array(
      'property' => 'media_gallery_allow_download',
    );
    $public_fields['media_gallery_expose_block'] = array(
      'property' => 'media_gallery_expose_block',
    );
    $public_fields['media_gallery_block_columns'] = array(
      'property' => 'media_gallery_block_columns',
    );
    $public_fields['media_gallery_block_rows'] = array(
      'property' => 'media_gallery_block_rows',
    );

    return $public_fields;
  }

}
