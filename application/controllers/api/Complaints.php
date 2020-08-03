<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Complaints extends REST_Controller{

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

  public function validateAPIKey(){
    
    $api_key = isset($_POST['api_key']) ? $_POST['api_key'] : NULL;
    $create_by = isset($_POST['create_by']) ? $_POST['create_by'] : NULL;
    
    if(! $this->lib_common->isValidAPIKey( $create_by, $api_key ) ){
      $this->form_validation->set_message("validateAPIKey"," Invalid API Key."); 
      return false; 
    }
    
    return true;

  } // End Function

  public function validateUserId(){
    
    $create_by = isset($_POST['create_by']) ? $_POST['create_by'] : NULL;
    
    if(! $this->lib_common->isValidUser($create_by) ){
      $this->form_validation->set_message("validateUserId","Invalid User."); 
      return false; 
    }

    return true;

  } // End Functio

  public function create_new_complaint_category_post(){

    if($this->form_validation->run('api_create_new_complaint_category') == TRUE ){

        $insert_array = [];
        $insert_array['category'] = isset($_POST['category']) ? $_POST['category'] : NULL;
        $int_record = $this->common_model->save_entry('master_complaint_category',$insert_array);

        if($int_record){

            $data['status_code'] = 1;
            $data['response'] = "Success";
            $data['message'] = "Record Added Successfully.";
            $data['data']['category'] = $int_record;
            $this->response($data,REST_Controller::HTTP_OK);
        }
        else{

            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "Record Could Not be added";
            $data['data']['category'] = NULL;
            $this->response($data,REST_Controller::HTTP_OK);
        }


    } // End IF Form Validation
    else{

        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['category'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);

    }
    

  } // End Function

  public function list_complaint_category_post(){

    if($this->form_validation->run('api_list_complaint_category') == TRUE ){

      $list_complaint_category = $this->common_model->get_entry_by_data('master_complaint_category',false,array('status' => 1));
      if(!empty($list_complaint_category)){

        $data['status_code'] = 1;
        $data['response'] = "Success";
        $data['message'] = count($list_complaint_category)." Records found ";
        $data['data']['list_complaint_category'] = $list_complaint_category;
        $this->response($data,REST_Controller::HTTP_OK);

      } // End IF Not Empty List
      else{
          
        $data['status_code'] = 0;
        $data['response'] = "Failed";
        $data['message'] = " No Records found ";
        $data['data']['list_complaint_category'] = $list_categories;
        $this->response($data,REST_Controller::HTTP_OK);

      }


    } // End IF Form Validation
    else{

        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['list_complaint_category'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);

    }

  } //End Function

  public function list_complaint_nature_post(){

    if($this->form_validation->run('api_list_complaint_nature') == TRUE ){

        $list_complaint_nature = $this->common_model->get_entry_by_data('master_complaint_nature',false,array('status' => 1));

        if(!empty($list_complaint_nature)){

          $data['status_code'] = 1;
          $data['response'] = "Success";
          $data['message'] = count($list_complaint_nature)." Records found ";
          $data['data']['list_complaint_nature'] = $list_complaint_nature;
          $this->response($data,REST_Controller::HTTP_OK);

        } // End IF Not Empty List
        else{

          $data['status_code'] = 0;
          $data['response'] = "Failed";
          $data['message'] = " No Records found ";
          $data['data']['list_categories'] = NULL;
          $this->response($data,REST_Controller::HTTP_OK);

        }


    } // End IF Form Validation
    else{

        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['list_complaint_nature'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);
    }

  } //End Function

  public function list_complaint_type_post(){

    if($this->form_validation->run('api_list_complaint_type') == TRUE ){
      $list_type = $this->common_model->get_entry_by_data('master_complaint_type',false,array('status' => 1));

      if(!empty($list_type)){

        $data['status_code'] = 1;
        $data['response'] = "Success";
        $data['message'] = count($list_type)." Records found ";
        $data['data']['list_type'] = $list_type;
        $this->response($data,REST_Controller::HTTP_OK);

      } // End IF Not Empty List
      else{
          
        $data['status_code'] = 0;
        $data['response'] = "Failed";
        $data['message'] = " No Records found ";
        $data['data']['list_type'] = $list_type;
        $this->response($data,REST_Controller::HTTP_OK);

      }

    } // End IF Form Validation
    else{

        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['list_type'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);
    }


  } // End Function



  
} // End Class