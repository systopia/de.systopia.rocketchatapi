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
  $spec['api'] = array(
    'name'         => 'api',
    'api.required' => 1,
    'type'         => CRM_Utils_Type::T_TEXT,
    'title'        => 'api path',
    'description'  => 'Rocketchat api url after /api/v1/. See https://docs.rocket.chat/api/rest-api/ for more information on api URLs',
  );
  $spec['argument'] = array(
    'name'         => 'argument',
    'api.required' => 0,
    'type'         => CRM_Utils_Type::T_LONGTEXT,
    'title'        => 'Api Argument',
    'description'  => 'Rocketchat api Arguments, JSON formatted. See https://docs.rocket.chat/api/rest-api/ for more information.\n
                       If none is given, a GET call to the given URL is made',
  );
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
    if (isset($params['argument'])) {
      $response = $test_connector->execute($params['api'], $params['argument']);
    } else {
      $response = $test_connector->execute($params['api']);
    }
  } catch (Exception $e) {
    throw new CiviCRM_API3_Exception($e->getMessage(), $e->getCode());
  }
  return civicrm_api3_create_success('Hooray. Version --> ' . json_encode($response));
}
