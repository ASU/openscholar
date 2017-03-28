<?php

class BiblioNodeRestfulBase extends VsiteExportNodeRestfulBase {

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

    $public_fields['title_field'] = array(
      'property' => 'title_field',
    );
    $public_fields['biblio_year'] = array(
      'property' => 'biblio_year',
    );
    $public_fields['biblio_type'] = array(
      'property' => 'biblio_type',
    );
    $public_fields['other_fields'] = array(
      'property' => 'other_fields',
    );
    $public_fields['biblio_authors_field'] = array(
      'property' => 'biblio_authors_field',
    );
    $public_fields['biblio_secondary_authors_field'] = array(
      'property' => 'biblio_secondary_authors_field',
    );
    $public_fields['biblio_tertiary_authors_field'] = array(
      'property' => 'biblio_tertiary_authors_field',
    );
    $public_fields['biblio_subsidiary_authors_field'] = array(
      'property' => 'biblio_subsidiary_authors_field',
    );
    $public_fields['biblio_corp_authors_field'] = array(
      'property' => 'biblio_corp_authors_field',
    );
    $public_fields['biblio_secondary_title'] = array(
      'property' => 'biblio_secondary_title',
    );
    $public_fields['biblio_tertiary_title'] = array(
      'property' => 'biblio_tertiary_title',
    );
    $public_fields['biblio_volume'] = array(
      'property' => 'biblio_volume',
    );
    $public_fields['biblio_number_of_volumes'] = array(
      'property' => 'biblio_number_of_volumes',
    );
    $public_fields['biblio_issue'] = array(
      'property' => 'biblio_issue',
    );
    $public_fields['biblio_edition'] = array(
      'property' => 'biblio_edition',
    );
    $public_fields['biblio_section'] = array(
      'property' => 'biblio_section',
    );
    $public_fields['biblio_number'] = array(
      'property' => 'biblio_number',
    );
    $public_fields['biblio_pages'] = array(
      'property' => 'biblio_pages',
    );
    $public_fields['biblio_date'] = array(
      'property' => 'biblio_date',
    );
    $public_fields['biblio_publisher'] = array(
      'property' => 'biblio_publisher',
    );
    $public_fields['biblio_place_published'] = array(
      'property' => 'biblio_place_published',
    );
    $public_fields['field_biblio_pub_month'] = array(
      'property' => 'field_biblio_pub_month',
    );
    $public_fields['biblio_type_of_work'] = array(
      'property' => 'biblio_type_of_work',
    );
    $public_fields['biblio_lang'] = array(
      'property' => 'biblio_lang',
    );
    $public_fields['biblio_other_author_affiliations'] = array(
      'property' => 'biblio_other_author_affiliations',
    );
    $public_fields['field_biblio_pub_day'] = array(
      'property' => 'field_biblio_pub_day',
    );
    $public_fields['biblio_isbn'] = array(
      'property' => 'biblio_isbn',
    );
    $public_fields['biblio_issn'] = array(
      'property' => 'biblio_issn',
    );
    $public_fields['biblio_accession_number'] = array(
      'property' => 'biblio_accession_number',
    );
    $public_fields['biblio_call_number'] = array(
      'property' => 'biblio_call_number',
    );
    $public_fields['biblio_other_number'] = array(
      'property' => 'biblio_other_number',
    );
    $public_fields['biblio_keywords'] = array(
      'property' => 'biblio_keywords',
    );
    $public_fields['biblio_abst_e'] = array(
      'property' => 'biblio_abst_e',
    );
    $public_fields['biblio_abst_f'] = array(
      'property' => 'biblio_abst_f',
    );
    $public_fields['biblio_notes'] = array(
      'property' => 'biblio_notes',
    );
    $public_fields['biblio_url'] = array(
      'property' => 'biblio_url',
    );
    $public_fields['biblio_doi'] = array(
      'property' => 'biblio_doi',
    );
    $public_fields['biblio_research_notes'] = array(
      'property' => 'biblio_research_notes',
    );
    $public_fields['biblio_custom1'] = array(
      'property' => 'biblio_custom1',
    );
    $public_fields['biblio_custom2'] = array(
      'property' => 'biblio_custom2',
    );
    $public_fields['biblio_custom3'] = array(
      'property' => 'biblio_custom3',
    );
    $public_fields['biblio_custom4'] = array(
      'property' => 'biblio_custom4',
    );
    $public_fields['biblio_custom5'] = array(
      'property' => 'biblio_custom5',
    );
    $public_fields['biblio_custom6'] = array(
      'property' => 'biblio_custom6',
    );
    $public_fields['biblio_custom7'] = array(
      'property' => 'biblio_custom7',
    );
    $public_fields['biblio_short_title'] = array(
      'property' => 'biblio_short_title',
    );
    $public_fields['biblio_translated_title'] = array(
      'property' => 'biblio_translated_title',
    );
    $public_fields['biblio_alternate_title'] = array(
      'property' => 'biblio_alternate_title',
    );
    $public_fields['biblio_original_publication'] = array(
      'property' => 'biblio_original_publication',
    );
    $public_fields['biblio_reprint_edition'] = array(
      'property' => 'biblio_reprint_edition',
    );
    $public_fields['biblio_citekey'] = array(
      'property' => 'biblio_citekey',
    );
    $public_fields['biblio_remote_db_name'] = array(
      'property' => 'biblio_remote_db_name',
    );
    $public_fields['biblio_coins'] = array(
      'property' => 'biblio_coins',
    );
    $public_fields['biblio_remote_db_provider'] = array(
      'property' => 'biblio_remote_db_provider',
    );
    $public_fields['biblio_auth_address'] = array(
      'property' => 'biblio_auth_address',
    );
    $public_fields['biblio_label'] = array(
      'property' => 'biblio_label',
    );
    $public_fields['biblio_access_date'] = array(
      'property' => 'biblio_access_date',
    );
    $public_fields['biblio_refereed'] = array(
      'property' => 'biblio_refereed',
    );
    $public_fields['redirect'] = array(
      'property' => 'redirect',
    );
    $public_fields['path'] = array(
      'property' => 'path',
    );
    $public_fields['field_upload'] = array(
      'property' => 'field_upload',
    );
    $public_fields['field_biblio_extra'] = array(
      'property' => 'field_biblio_extra',
    );
    $public_fields['field_biblio_redirect'] = array(
      'property' => 'field_biblio_redirect',
    );
    $public_fields['metatags'] = array(
      'property' => 'metatags',
    );
    $public_fields['field_biblio_image'] = array(
      'property' => 'field_biblio_image',
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
