<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Module extends REST_Controller {
	

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
  
  public function index()
	{

  } // End Function
  
  public function module_enable_disable_post(){

    if($this->form_validation->run('api_module_enable_disable') == TRUE ){

      $effective_date = date('Y-m-d H:i:s');



    } // End If Form Validation
    else{

    }

  } // End Function

  public function create_new_module_post(){
      
      if($this->form_validation->run('api_create_new_module') == TRUE ){

        $this->db->trans_start();
        $effective_date = date('Y-m-d H:i:s');

        $insert_array = [];
        
        $insert_array['name'] = isset($_POST['name']) ? $_POST['name'] : NULL;
        $insert_array['description'] = isset($_POST['description']) ? $_POST['description'] : NULL;
        $insert_array['create_datetime'] = $effective_date;
        $insert_array['create_by'] = isset($_POST['user_id']) ? $_POST['user_id'] : NULL;

        pr($insert_array); die;

        $int_record = $this->common_model->save_entry('master_modules',$insert_array);

        if($int_record){
          
          $this->db->trans_complete();

          $data['response'] = "Success";
          $data['message'] = "Record Added Successfully!";
          
          $this->response($data,REST_Controller::HTTP_OK);

        }
        else{

          $this->db->trans_rollback();

          $data['response'] = "Failed";
          $data['message'] = "Record Could not be added";
          $data['data']['module'] = NULL;
          $this->response($data,REST_Controller::HTTP_OK);

        }


     } // End If Form Validation
     else{

        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['module'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);

     }

  } // End Function

  public function enable_disable_module_post(){


  } // End Function

  public function list_modules_post(){


  } // End Function



} // End Class


	
	
