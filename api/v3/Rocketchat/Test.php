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
 * Rocketchat.Test API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_rocketchat_Test_spec(&$spec) {
  // simple boilerplate api command to test rocketchat connectivity
}

/**
 * Rocketchat.Test API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_rocketchat_Test($params) {
  try {
    // do something here
  } catch (Exception $e) {
    throw new CiviCRM_API3_Exception($e->getMessage(), $e->getCode());
  }
  return civicrm_api3_create_success('Hooray');
}
