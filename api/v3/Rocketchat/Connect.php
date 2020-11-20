<?php
use CRM_Rocketchatapi_ExtensionUtil as E;

/**
 * Rocketchat.Connect API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_rocketchat_connect_spec(&$spec) {
  // nothing to do here.
}

/**
 * Rocketchat.Connect API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_rocketchat_connect($params) {
  try {
    // do something here
    $test_connector = new CRM_Rocketchatapi_Rocketchatconnector();
    $version = $test_connector->version();
  } catch (Exception $e) {
    throw new CiviCRM_API3_Exception($e->getMessage(), $e->getCode());
  }
  return civicrm_api3_create_success('Hooray. Version --> ' . $version);
}
