<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Master_occupations extends REST_Controller{

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

//create===================================//
public function create_new_occupation_post()

{

   if($this->form_validation->run('api_create_new_occupation') == TRUE ){

        
        $this->db->trans_start();

      $create_array=[];
      $create_array['name']= isset($_POST['name']) ? $_POST['name'] : NULL;
      $create_array['description']= isset($_POST['description']) ? $_POST['description'] : NULL;
       $create_array['create_datetime']= CURRENT_DATETIME;
       $create_array['create_by']= isset($_POST['create_by']) ? $_POST['create_by'] : NULL;


       // print_r($create_array); die;

       $create_master= $this->common_model->save_entry('master_occupations',$create_array);
       if($create_master)
       {
          $this->db->trans_complete();

          $data['status_code'] = 1;
          $data['response'] = "Success";
          $data['message'] = "Record Added Successfully!";
          $data['data']['occupation'] = $create_master;
          $this->response($data,REST_Controller::HTTP_OK);
       }
       else
       {
       // $this->response('may be databse query or server problem',REST_Controller::HTTP_BAD_REQUEST);
         $this->db->trans_rollback();

          $data['status_code'] = 0;
          $data['response'] = "Failed";
          $data['message'] = "Record Could Not be Added.";
          $data['data']['occupation'] = NULL;
          $this->response($data,REST_Controller::HTTP_OK);
       }


 }
 else{
        
        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['occupation'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);
    }



  } // create method close



//Edit  occupations=================================
public function update_occupation_detail_post()
{

     if($this->form_validation->run('api_update_occupation_detail') == TRUE ){

        
        $this->db->trans_start();

  $id= $this->input->post('id');
 $edit_array=[];
 
 $edit_array['name']=$this->input->post('name');
 $edit_array['description']=$this->input->post('description');
 $edit_array['update_by']=$this->input->post('create_by');
 $edit_array['update_datetime']= CURRENT_DATETIME;
 // echo $id;
 //   print_r($edit_array);die;
 // if(!empty($edit_array['description'])  AND !empty($edit_array['update_by']) AND !empty($id))
 // {
  $edit_master=$this->common_model->update_entry('master_occupations',$edit_array,array('id'=>$id));

   if($edit_master)
   {
     $this->db->trans_complete();

          $data['status_code'] = 1;
          $data['response'] = "Success";
          $data['message'] = "Record updated Successfully!";
          $data['data']['occupation'] = $this->common_model->get_entry_by_data('master_occupations',true,array('id' => '6'));          $this->response($data,REST_Controller::HTTP_OK);
     }
   else
   {
 // $this->response('may be databse query or server problem',REST_Controller::HTTP_BAD_REQUEST);
              $this->db->trans_rollback();

          $data['status_code'] = 0;
          $data['response'] = "Failed";
          $data['message'] = "Record Could Not be updated.";
          $data['data']['occupation'] = NULL;
          $this->response($data,REST_Controller::HTTP_OK);
   }  

}//end if for checking is not empty

else{
        
        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
         $data['data']['occupation'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);
    }

} //edit methd fun

//change status===========================
public function occupation_status_post()
{
  
  if($this->form_validation->run('api_occupation_status') == TRUE ){
        $this->db->trans_start();
    
    $id= $this->input->post('id');
  
 $change_status=[];
  $change_status['status']= $this->input->post('status');

  $status=$this->common_model->update_entry('master_occupations',$change_status,array('id'=>$id));
   if($status)
   {
    $this->db->trans_complete();

          $data['status_code'] = 1;
          $data['response'] = "Success";
          $data['message'] = "status change Successfully!";
          $data['data']['occupation'] = $status;

          $this->response($data,REST_Controller::HTTP_OK);
     }
   else
    { 
    $this->db->trans_rollback();

          $data['status_code'] = 0;
          $data['response'] = "Failed";
          $data['message'] = "status did not change.";
          $data['data']['occupation'] = NULL;

          $this->response($data,REST_Controller::HTTP_OK);
   }  

}//end if for checking validation

else
      {
         $data['status_code'] = -1;
  $data['response'] = "Failed";
          $data['data']['occupation'] = NULL;
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $this->response($data,REST_Controller::HTTP_OK);

}//end else part for checking is not empty
      

} //end methd fun


}
  ?>