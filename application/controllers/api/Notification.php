<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends Access_Controller {
	
  function __construct()
  {
    	// Construct the parent class
		  parent::__construct();
	}
  public function index()
	{

  }

  public function send_email_post(){

    $data = [];
    $succ_email_sent = [];
    $email_not_sent = [];

    if($this->form_validation->run('api_send_email') == TRUE){

    } // End IF
    else{

      $data['response'] = "Failed";
      $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));

      $data['succ_email_sent'] = NULL;
      $data['email_not_sent'] = NULL;
      $this->response($data,REST_Controller::HTTP_OK);

    }

  } // End Function
  
} // End Class


	
	
