<?php

class LayoutsValidate extends VsiteBackupObjectValidate {

  /**
   * Overrides ObjectValidateBase::publicFieldsInfo().
   */
  public function publicFieldsInfo() {
    $fields = parent::publicFieldsInfo();

    FieldsInfo::setFieldInfo($fields['blocks'], $this)
      ->setProperty('blocks')
      ->setRequired();

    FieldsInfo::setFieldInfo($fields['object_id'], $this)
      ->setProperty('object_id')
      ->setRequired();

    return $fields;
  }

}
