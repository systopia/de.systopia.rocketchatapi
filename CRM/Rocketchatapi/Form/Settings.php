<?php
/*-------------------------------------------------------+
| SYSTOPIA Rocketchat API Extension                      |
| Copyright (C) 2020 SYSTOPIA                            |
| Author: P. Batroff (batroff@systopia.de)               |
+--------------------------------------------------------+
| This program is released as free software under the    |
| Affero GPL license. You can redistribute it and/or     |
| modify it under the terms of this license which you    |
| can read by viewing the included agpl.txt or online    |
| at www.gnu.org/licenses/agpl.html. Removal of this     |
| copyright header is strictly prohibited without        |
| written permission from the original author(s).        |
+--------------------------------------------------------*/


use CRM_Rocketchatapi_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Rocketchatapi_Form_Settings extends CRM_Core_Form {
  public function buildQuickForm() {

    $config = CRM_Rocketchatapi_Config::singleton();
    $current_values = $config->getSettings();

    // add form elements
    $this->add(
      'text',
      'rocketchat_url',
      E::ts('Rocketchat Server URL'),
      array("class" => "huge"),
      FALSE
    );
    $this->add(
      'text',
      'rocketchat_un',
      E::ts('Rocketchat Username'),
      array("class" => "huge"),
      FALSE
    );
    $this->add(
      'password',
      'rocketchat_pw',
      E::ts('Rocketchat Password'),
      array("class" => "huge"),
      FALSE
    );

    // set default values
    $this->setDefaults($current_values);

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    parent::buildQuickForm();
  }

  /**
   * Override validation for custom tokens
   * @return bool|void
   */
  public function validate() {
    parent::validate();

    $this->_submitValues;
    $url = $this->_submitValues['rocketchat_url'];

    if (!preg_match("/\b(?:https:\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
      $this->_errors["rocketchat_url"] = "Please enter a valid Rocketchat URl! Domain needs https://domain.com - no trailing / in the end";
    }
    if (preg_match("/.*\/$/", $url)) {
      $this->_errors["rocketchat_url"] = "Please don't use a trailing / for the url";
    }

    return count($this->_errors) == 0;
  }

  public function postProcess() {
    $config = CRM_Rocketchatapi_Config::singleton();
    $values = $this->exportValues();
    $settings = $config->getSettings();
    $settings_in_form = $this->getSettingsInForm();
    foreach ($settings_in_form as $name) {
      $settings[$name] = CRM_Utils_Array::value($name, $values, NULL);
    }
    $config->setSettings($settings);
    parent::postProcess();
  }


  /**
   * get the elements of the form
   * used as a filter for the values array from post Process
   * @return array
   */
  protected function getSettingsInForm() {
    return array(
      'rocketchat_url',
      'rocketchat_un',
      'rocketchat_pw',
    );
  }

}
