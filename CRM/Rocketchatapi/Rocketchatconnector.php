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

include "/../../resources/lib/vendor/bootstrap.php";

class CRM_Rocketchatapi_Rocketchatconnector {

  private $api ='';
  private $api_root = "/api/v1/";
  private $username ='';
  private $password ='';
  private $user_id = '';


  /**
   * @throws API_Exception
   */
  public function __construct() {
    if (!file_exists(__DIR__ . '/../../resources/lib/vendor/nategood/httpful/bootstrap.php')) {
      throw new API_Exception("Httpful not available. Please go to resources/lib and install via composer");
    }
    require __DIR__ . '/../../resources/lib/vendor/nategood/httpful/bootstrap.php';

    $config = CRM_Rocketchatapi_Config::singleton();
    $this->api = $config->getSetting('rocketchat_url') . $this->api_root;
    $this->username = $config->getSetting('rocketchat_un');
    $this->password = $config->getSetting('rocketchat_pw');

    if (empty($this->api) || empty($this->username) || empty($this->password)) {
      throw new API_Exception("Rocketchat Server parameters not configured. Aborting API call");
    }
    $this->login();
  }


  /**
   * Authenticate with the REST API.
   * @throws API_Exception
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
    throw new API_Exception($response->body->message);
  }

  /**
   * Get version information. This simple method requires no authentication.
   */
  public function version() {
    $response = \Httpful\Request::get( $this->api . 'info' )->send();
    return $response->body->info->version;
  }




}
