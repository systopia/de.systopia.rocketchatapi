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
use Httpful\Request;

include "/../../vendor/autoload.php";

class CRM_Rocketchatapi_Rocketchatconnector {

  private $api ='';
  private $api_root = "/api/v1/";
  private $username ='';
  private $password ='';
  private $user_id = '';


  /**
   * CRM_Rocketchatapi_Rocketchatconnector constructor.
   *  Sets default paramter for this class and performs a login with the configured credentials
   *
   * @throws API_Exception
   * @throws Exception
   */
  public function __construct() {
    if (!file_exists(__DIR__ . '/../../vendor/autoload.php')) {
      throw new Exception("Httpful not available. Please go to resources/lib and install via composer");
    }
    require __DIR__ . '/../../vendor/autoload.php';

    $config = CRM_Rocketchatapi_Config::singleton();
    $this->api = $config->getSetting('rocketchat_url') . $this->api_root;
    $this->username = $config->getSetting('rocketchat_un');
    $this->password = $config->getSetting('rocketchat_pw');

    if (empty($this->api) || empty($this->username) || empty($this->password)) {
      throw new Exception("Rocketchat Server parameters not configured. Aborting API call");
    }
    $this->login();
  }


  /**
   * Destructor - Invalidate the current Rest Token
   *  TODO: Is this needed every call?
   * @throws \Httpful\Exception\ConnectionErrorException
   */
  public function __destruct() {
    $this->execute_get("logout");
  }


  /**
   * Authenticate with the REST API.
   * @throws API_Exception
   * @throws Exception
   */
  private function login() {
    $response = Request::post( $this->api . 'login' )
      ->body(json_encode(array( 'user' => $this->username, 'password' => $this->password )))
      ->sendsJson()
      ->send();

    if( $response->code == 200 && isset($response->body->status) && $response->body->status == 'success' ) {
      // save auth token for future requests
      $tmp = Request::init()
        ->addHeader('X-Auth-Token', $response->body->data->authToken)
        ->addHeader('X-User-Id', $response->body->data->userId)
        ->sendsJson();  // didn't work sending an array, JSON works fine.
      // should be persistent now, so that future calls can use auth token and id
      Request::ini( $tmp );
      $this->user_id = $response->body->data->userId;
      return;
    }
    throw new Exception($response->body->message);
  }


  /**
   * Executes generic rocket chat api call
   * see https://docs.rocket.chat/api/rest-api
   * @param $api
   *  default api argument. Will be added to /api/v1/
   *
   * @param $params
   *  JSON formated parameter array
   *
   * @return \Httpful\Response
   *  Full Response object
   * @throws \Httpful\Exception\ConnectionErrorException
   * @throws Exception
   */
  public function execute_post($api, $params) {
    if (!$this->is_json($params)) {
      throw new Exception("Parameter is is malformed. Not valid json");
    }

    return Request::post($this->api . $api)
      ->body($params)
      ->send();
  }

  /**
   * Execute a GET Request to Rocketchat api
   * Params is optional, but if provided in addition to the api path they will be added
   * See https://docs.rocket.chat/api/rest-api/query-and-fields-info for use cases
   *
   * @param $api
   * @param null $params
   *  array
   * @return \Httpful\Response
   * @throws \Httpful\Exception\ConnectionErrorException
   */
  public function execute_get($api, $params=NULL) {

    $api_query = $this->api . $api;
    if (!empty($params)) {
      $api_query .= $this->build_query($params);
    }
    return Request::get($api_query)->send();
  }

  /**
   * helper function to parse parameter array and format to meet requirements for
   * Rocketchat query/field api
   * https://docs.rocket.chat/api/rest-api/query-and-fields-info
   *
   * @param $params
   * @return string
   */
  private function build_query($params) {
    $first = TRUE;
    $query = "?";
    foreach ($params as $arg => $value) {
      if(!$first) {
        $query .= '&'; // more arguments coming
      }
      $query .= $arg . "=" . json_encode($value);
      $first = FALSE;
    }
    return $query;
  }


  /**
   * helper function
   * determines if given string is JSON. Returns True when NULL
   *
   * @param $str
   * @return bool
   */
  private function is_json($str) {
    if ($str === NULL) {
      return TRUE;
    }
    json_decode($str);
    return (json_last_error() == JSON_ERROR_NONE);
  }

}
