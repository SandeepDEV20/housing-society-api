<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class CreateUsers_profile extends REST_Controller{

  function __construct()
  {
    // Construct the parent class
    parent::__construct();

    // Configure limits on our controller methods
    // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
    $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
    $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
    $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    //Test API Key: 21232f297a57a5a743894a0e4a801fc3

  }


public function UsersProfile_post()
{

	
  $insert_user_array = [];   
        // $insert_user_array['access_level'] = isset($_POST['access_level']) ? $_POST['access_level'] : NULL;
        // $insert_user_array['fk_master_society_id'] = isset($_POST['fk_master_society_id']) ? $_POST['fk_master_society_id'] : NULL;
        // $insert_user_array['fk_society_user_type_id'] = isset($_POST['fk_society_user_type_id']) ? $_POST['fk_society_user_type_id'] : NULL;
        // $insert_user_array['user_name'] = isset($_POST['user_name']) ? $_POST['user_name'] : NULL;
        // $insert_user_array['password'] = isset($_POST['password']) ? md5($_POST['password']) : NULL;
        // $insert_user_array['api_key'] = isset($_POST['api_key']) ? $_POST['api_key'] : NULL;
        // $insert_user_array['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : NULL;
        // $insert_user_array['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : NULL;
        // $insert_user_array['contact'] = isset($_POST['contact']) ? $_POST['contact'] : NULL;
        // $insert_user_array['email'] = isset($_POST['email']) ? $_POST['email'] : NULL;
        // $insert_user_array['address_line1'] = isset($_POST['address_line1']) ? $_POST['address_line1'] : NULL;
        // $insert_user_array['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : NULL;
        // $insert_user_array['district'] = isset($_POST['district']) ? $_POST['district'] : NULL;
        // $insert_user_array['state'] = isset($_POST['state']) ? $_POST['state'] : NULL;
        // $insert_user_array['pincode'] = isset($_POST['pincode']) ? $_POST['pincode'] : NULL;
        // $insert_user_array['occupation'] = isset($_POST['occupation']) ? $_POST['occupation'] : NULL;
        // $insert_user_array['blood_group'] = isset($_POST['blood_group']) ? $_POST['blood_group'] : NULL;
        // $insert_user_array['birth_date'] = isset($_POST['birth_date']) ? $_POST['birth_date'] : NULL;
        // $insert_user_array['joining_date'] = isset($_POST['joining_date']) ? $_POST['joining_date'] : NULL;
        // $insert_user_array['fk_designation_id'] = isset($_POST['fk_designation_id']) ? $_POST['fk_designation_id'] : NULL;

        // $insert_user_array['create_datetime'] = CURRENT_DATETIME;
        // $insert_user_array['create_by'] = isset($_POST['user_id']) ? $_POST['user_id'] : NULL;





        $insert_user_array['access_level'] = isset($_POST['access_level']) ? $this->input->post('access_level') : NULL;
        $insert_user_array['fk_master_society_id'] = isset($_POST['fk_master_society_id']) ? $this->input->post('fk_master_society_id') : NULL;
        $insert_user_array['fk_society_user_type_id'] = isset($_POST['fk_society_user_type_id']) ? $this->input->post('fk_society_user_type_id') : NULL;
        $insert_user_array['user_name'] = isset($_POST['user_name']) ? $this->input->post('user_name') : NULL;
        $insert_user_array['password'] = isset($_POST['password']) ? md5($this->input->post('password')) : NULL;
        $insert_user_array['api_key'] = isset($_POST['api_key']) ? $this->input->post('api_key') : NULL;
        $insert_user_array['first_name'] = isset($_POST['first_name']) ? $this->input->post('first_name') : NULL;
        $insert_user_array['last_name'] = isset($_POST['last_name']) ? $this->input->post('last_name'): NULL;
        $insert_user_array['contact'] = isset($_POST['contact']) ? $this->input->post('contact') : NULL;
        $insert_user_array['email'] = isset($_POST['email']) ? $this->input->post('email') : NULL;
        $insert_user_array['address_line1'] = isset($_POST['address_line1']) ? $this->input->post('address_line1') : NULL;
        $insert_user_array['address_line2'] = isset($_POST['address_line2']) ? $this->input->post('address_line2') : NULL;
        $insert_user_array['district'] = isset($_POST['district']) ? $this->input->post('district') : NULL;
        $insert_user_array['state'] = isset($_POST['state']) ? $this->input->post('state') : NULL;
        $insert_user_array['pincode'] = isset($_POST['pincode']) ? $this->input->post('pincode') : NULL;
        $insert_user_array['occupation'] = isset($_POST['occupation']) ? $this->input->post('occupation') : NULL;
        $insert_user_array['blood_group'] = isset($_POST['blood_group']) ? $this->input->post('blood_group') : NULL;
        $insert_user_array['birth_date'] = isset($_POST['birth_date']) ? $this->input->post('birth_date') : NULL;
        $insert_user_array['joining_date'] = isset($_POST['joining_date']) ? $this->input->post('joining_date') : NULL;
        $insert_user_array['fk_designation_id'] = isset($_POST['fk_designation_id']) ? $this->input->post('fk_designation_id') : NULL;

        $insert_user_array['create_datetime'] = CURRENT_DATETIME;
        $insert_user_array['create_by'] = isset($_POST['user_id']) ? $this->input->post('user_id') : NULL;

        
              
      $insert_user = $this->common_model->save_entry('users',$insert_user_array);
      if($insert_user)
	 			{
	 				$this->response([
					'status'=>TRUE,
					'message'=>'insert user'


						],REST_Controller::HTTP_OK);
	 			}
	 			else
				{
						$this->response("some problems occcured,try again.",REST_Controller::HTTP_BAD_REQUEST);
				}


}


}
?>