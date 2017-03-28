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
    );
    $public_fields['path'] = array(
      'property' => 'path',
    );
    $public_fields['redirect'] = array(
      'property' => 'redirect',
    );
    $public_fields['media_gallery_file'] = array(
      'property' => 'media_gallery_file',
    );
    $public_fields['media_gallery_format'] = array(
      'property' => 'media_gallery_format',
    );
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
    $public_fields['metatags'] = array(
      'property' => 'metatags',
    );
    $public_fields['og_group_ref'] = array(
      'property' => 'og_group_ref',
    );
    $public_fields['og_vocabulary'] = array(
      'property' => 'og_vocabulary',
    );

    return $public_fields;
  }

}
