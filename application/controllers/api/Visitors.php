<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Visitors extends REST_Controller {
	
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

  public function validateVisitorId(){
    
    $fk_visitor_id = isset($_POST['fk_visitor_id']) ? $_POST['fk_visitor_id'] : NULL;
    $info = $this->common_model->get_entry_by_data('visitors',true,array( 'id' => $fk_visitor_id));
    
    if(empty($info)){
      $this->form_validation->set_message("validateVisitorId"," Invalid Visitor Id"); 
      return false; 
    }

    return true;
  } // End Function

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

  } // End Function

  public function list_visitors_post(){

    $user_apikey = $_POST['api_key']   = $this->input->post('user_apikey');
    $access_by   = $this->input->post('access_by');
    $user_id     = $_POST['create_by'] = $this->input->post('user_id');
    $visit_year_month = $this->input->post('visit_year_month');

    if($user_apikey && ($this->validateUserId()) && ($this->validateAPIKey())){

      if ($access_by=='owner') {
        
        $query = $this->common_model->run_query('SELECT `hsm_visitors`.`first_name`, `hsm_visitors`.`last_name`,`hsm_visitors`.`mobile`, `hsm_visitors_visits`.`in_time`, `hsm_visitors_visits`.`out_time`,`hsm_visitors_visits`.`purpose` FROM `hsm_visitors_visits` RIGHT JOIN `hsm_visitors` ON `hsm_visitors`.`id`=`hsm_visitors_visits`.`fk_visitor_id` where `hsm_visitors_visits`.`fk_visit_person_id`='.$user_id.' and `hsm_visitors_visits`.`in_time` like "%'.$visit_year_month.'%" ');

          $data['visitors'] = $query;
      } else {
            $query = $this->common_model->run_query('SELECT `hsm_visitors`.`first_name`, `hsm_visitors`.`last_name`,`hsm_visitors`.`mobile`, `hsm_visitors_visits`.`in_time`, `hsm_visitors_visits`.`out_time`,`hsm_visitors_visits`.`purpose` FROM `hsm_visitors_visits` RIGHT JOIN `hsm_visitors` ON `hsm_visitors`.`id`=`hsm_visitors_visits`.`fk_visitor_id` where `hsm_visitors_visits`.`in_time` like "%'.$visit_year_month.'%" ');
            $data['visitors'] = $query;
      }

      $data['status_code'] = 1;
      $data['response']    = "Success";
      $data['message']     = count($query).' data found.';

    } else {
      $data['status_code'] = -1;
      $data['response']    = "Failed";
      $data['message']     = 'User API kay & user id does not matched.';
    }

    $this->response($data,REST_Controller::HTTP_OK);

  } // End Function

  
  public function create_new_visiting_request_post(){
      
      if($this->form_validation->run('api_create_new_visiting_request') == TRUE ){
        
        $this->db->trans_start();
        $effective_date = date('Y-m-d H:i:s');

        $insert_array = [];

        $insert_array['fk_visitor_id'] = isset($_POST['fk_visitor_id']) ? $_POST['fk_visitor_id'] : NULL;
        $insert_array['fk_visit_person_id'] = isset($_POST['fk_visit_person_id']) ? $_POST['fk_visit_person_id'] : NULL;
        $insert_array['purpose'] = isset($_POST['purpose']) ? $_POST['purpose'] : NULL;
        $insert_array['in_time'] = isset($_POST['in_time']) ? $_POST['in_time'] : NULL;
        $insert_array['out_time'] = isset($_POST['out_time']) ? $_POST['out_time'] : NULL;
        $insert_array['vehicle_detail'] = isset($_POST['vehicle_detail']) ? $_POST['vehicle_detail'] : NULL;
        $insert_array['create_by'] = isset($_POST['create_by']) ? $_POST['create_by'] : NULL;
        $insert_array['create_datetime'] = $effective_date;
        
        $int_record = $this->common_model->save_entry('visitors_visits',$insert_array);

        if($int_record){
          
          $this->db->trans_complete();

          $data['status_code'] = 1;
          $data['response'] = "Success";
          $data['message'] = "Record Added Successfully!";
          $data['data']['visiting_request_detail'] = $int_record;
          $this->response($data,REST_Controller::HTTP_OK);

        }
        else{

          $this->db->trans_rollback();

          $data['status_code'] = 0;
          $data['response'] = "Failed";
          $data['message'] = "Record Could Not be Added.";
          $data['data']['visiting_request_detail'] = NULL;
          $this->response($data,REST_Controller::HTTP_OK);

        }

    }
    else{
        
        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['visiting_request_detail'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);
    }

  } // End Function

  public function create_new_visitor_post(){
    
    if($this->form_validation->run('api_create_new_visitor') == TRUE ){
        
        $fk_visitor_id = NULL;
        $int_record = NULL;

        $effective_date = date('Y-m-d H:i:s');
        $save_in_time = isset($_POST['save_in_time']) ? $_POST['save_in_time'] : NULL;
        $visiting_request_detail = NULL;

        
        $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : NULL;
        $visitor_detail = $this->common_model->get_entry_by_data('visitors', true, array('mobile' => $mobile));
        $fk_visitor_id = isset($visitor_detail['id']) ? $visitor_detail['id'] : NULL;
        
        // Create New Visitor 

        if(empty($visitor_detail)){

          $insert_array = [];

          $insert_array['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : NULL;
          $insert_array['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : NULL;
          $insert_array['mobile'] = isset($_POST['mobile']) ? $_POST['mobile'] : NULL;
          $insert_array['otp_verification_status'] = isset($_POST['otp_verification_status']) ? $_POST['otp_verification_status'] : 0;
          
          $insert_array['alternate_contact'] = isset($_POST['alternate_contact']) ? $_POST['alternate_contact'] : NULL;
          $insert_array['address_line1'] = isset($_POST['address_line1']) ? $_POST['address_line1'] : NULL;
          $insert_array['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : NULL;
          $insert_array['address_line3'] = isset($_POST['address_line3']) ? $_POST['address_line3'] : NULL;
          
          $insert_array['fk_city_id'] = isset($_POST['fk_city_id']) ? $_POST['fk_city_id'] : NULL;
          $insert_array['pin_code'] = isset($_POST['pin_code']) ? $_POST['pin_code'] : NULL;
          $insert_array['pin_code'] = isset($_POST['pin_code']) ? $_POST['pin_code'] : NULL;

          $insert_array['create_by'] = isset($_POST['create_by']) ? $_POST['create_by'] : NULL;
          $insert_array['create_datetime'] = $effective_date;

          $int_record = $this->common_model->save_entry('visitors',$insert_array);
          $fk_visitor_id = isset($int_record['id']) ? $int_record['id'] : NULL;


        } // End IF Visitor Not Exists
        
        

        if( "YES" == $save_in_time ){
                
            // Call API To Create Visiting Request
            $post_data = [];
            $post_data['fk_visitor_id'] = $fk_visitor_id;
            $post_data['fk_visit_person_id'] = isset($_POST['fk_visit_person_id']) ? $_POST['fk_visit_person_id'] : NULL;
            $post_data['purpose'] = isset($_POST['purpose']) ? $_POST['purpose'] : NULL;
            $post_data['in_time'] = isset($_POST['in_time']) ? $_POST['in_time'] : NULL;
            $post_data['out_time'] = isset($_POST['out_time']) ? $_POST['out_time'] : NULL;
            $post_data['vehicle_detail'] = isset($_POST['vehicle_detail']) ? $_POST['vehicle_detail'] : NULL;
            $post_data['create_by'] = isset($_POST['create_by']) ? $_POST['create_by'] : NULL;
            $post_data['api_key'] = isset($_POST['api_key']) ? $_POST['api_key'] : NULL;

            //pr($post_data); die;

            $response = json_decode($this->lib_common->callAPI('POST',base_url().'api/visitors/create_new_visiting_request',$post_data));
            //pr($response);  die;

            if( isset($response->response) && $response->response == "Success"){
              $visiting_request_detail = isset($response->data->visiting_request_detail) ? $response->data->visiting_request_detail : NULL;
            }


        } // End IF Save IN Time Process

            if( !empty($int_record) ){

              $data['status_code'] = 1;
              $data['response'] = "Success";
              $data['message'] = "Visitor Create Successfully ";
              $data['data']['visitor_detail'] = $int_record;
              $data['data']['visiting_request_detail'] = $visiting_request_detail;
              $this->response($data,REST_Controller::HTTP_OK);

            }
            else if( !empty($visiting_request_detail) ){
                
                $data['status_code'] = 1;
                $data['response'] = "Success";
                $data['message'] = "Visitor Create Successfully ";
                $data['data']['visitor_detail'] = $visitor_detail;
                $data['data']['visiting_request_detail'] = $visiting_request_detail;
                $this->response($data,REST_Controller::HTTP_OK);

            }
            else {
                
                $data['status_code'] = 0;
                $data['response'] = "Failed";
                $data['message'] = "Record Could Not be added.";
                $data['data']['visitor_detail'] = NULL;
                $data['data']['visiting_request_detail'] = NULL;
                $this->response($data,REST_Controller::HTTP_OK);
            }

    } // End IF Form Validation
    else{

        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['visitor_detail'] = NULL;
        $data['data']['visiting_request_detail'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);

    }


  } // End Function
  

  public function update_visitor_detail_post(){

    if($this->form_validation->run('api_update_visitor') == TRUE ){

    }
    else{

    }

  } // End Function

  public function block_unblock_visitor_post(){

    if($this->form_validation->run('api_block_unblock_visitor') == TRUE ){

    }
    else{

    }

  } // End Function

} // End Class


	
	
