<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller{

  function __construct()
  {
      // Construct the parent class
      parent::__construct();
      // Configure limits on our controller methods
      // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
      $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
      $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
      $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
      
  }

  public function login_post(){

    $user_name = isset($_POST['user_name']) ?  trim($_POST['user_name']) : NULL;
    $password = isset($_POST['password']) ?  str_rot13(trim($_POST['password'])) : NULL;
    
    // Status Code 1 => Successful login, 0 => Failed Login, -1 => Form Validation Error 

    if( $this->form_validation->run('api_login') == TRUE ){
      
      $res = $this->common_model->get_entry_by_data('users',true,array('fk_user_status_id' => 1, 'user_name' => $user_name, 'password' => MD5($password)));

      if(!empty($res)){

          $user = [];
          
          $user['id'] = isset($res['id']) ? $res['id'] : NULL;
          $user['first_name'] = isset($res['first_name']) ? $res['first_name'] : NULL;
          $user['last_name'] = isset($res['last_name']) ? $res['last_name'] : NULL;
          $user['api_key'] = isset($res['api_key']) ? $res['api_key'] : NULL;
          $user['email'] = isset($res['email']) ? $res['email'] : NULL;
          $user['contact'] = isset($res['contact']) ? $res['contact'] : NULL;
          $user['fk_user_status_id'] = isset($res['fk_status_id']) ? $res['fk_status_id'] : NULL;


          $data['status_code'] = 1;
          $data['response'] = "Success";
          $data['message'] = "Login Successful.";
          $data['data']['user'] = $user;
          $this->response($data,REST_Controller::HTTP_OK);


        }
        else{

            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "Invalid Username Or Password ";
            $data['data']['user'] = NULL;
            $this->response($data,REST_Controller::HTTP_OK);
        }

    } // End IF Form Validation
    else{

        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['user'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);
    }

  } // End Function
  
  

} // End Class

       