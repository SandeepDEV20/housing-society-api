<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Master_reminder extends REST_Controller{

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

  public function Add_post()
  {
      $add_array=[];
      $add_array['name']= isset($_POST['name']) ? $this->input->post('name'):NULL;
      $add_array['description']= isset($_POST['description'])?$this->input->post('description'):NULL;
       $add_array['create_datetime']= CURRENT_DATETIME;
       $add_array['create_by']= isset($_POST['create_by'])?$this->input->post('create_by'):NULL;


       // print_r($add_array); die;

       $add_master= $this->common_model->save_entry('master_reminders_type',$add_array);
       if($add_master)
       {

        $this->response([
                       'status'=>TRUE,
                       'msg'=>'Add data'],
                         REST_Controller::HTTP_OK
                          );
       }
       else
       {
       $this->response('may be databse query or server problem',REST_Controller::HTTP_BAD_REQUEST);
       }

  } // add method close


//======================================================================================================================//

  public function Edit_post()
{

  $id= $this->input->post('id');
 $edit_array=[];

 $edit_array['description']=$this->input->post('description');
 $edit_array['update_by']=$this->input->post('update_by');
 $edit_array['update_datetime']= CURRENT_DATETIME;
 // echo $id;
 //   print_r($edit_array);die;
 if(!empty($edit_array['description'])  AND !empty($edit_array['update_by']) AND !empty($id))
 {
  $edit_master=$this->common_model->update_entry('master_reminders_type',$edit_array,array('id'=>$id));
   if($edit_master)
   {
     $this->response([
                    'status'=>TRUE,
                     'msg'=>'Data  Updated'],REST_Controller::HTTP_OK);
     }
   else
   {
 $this->response('may be databse query or server problem',REST_Controller::HTTP_BAD_REQUEST);
   }  

}//end if for checking is not empty

else
      {
        $this->response([
          'status'=>FALSE,
          'message'=>' Please fill the data.'


        ],REST_Controller::HTTP_BAD_REQUEST);

      }

} //edit methd fun

//======================================================================================================================//

public function Status_post()
{

  $id= $this->input->post('id');
  
 $change_status=[];
  $change_status['status']= $this->input->post('status');


 // echo $id;
 // print_r($change_status);die;
 if($change_status['status']>=0 AND $change_status['status']<=1 AND $change_status['status'] !=''  AND !empty($id))
 {
  $status=$this->common_model->update_entry('master_reminders_type',$change_status,array('id'=>$id));
   if($status)
   {
     $this->response([
                    'status'=>TRUE,
                     'msg'=>'status has been changed.'],REST_Controller::HTTP_OK);
     }
   else
   {
 $this->response('may be databse query or server problem',REST_Controller::HTTP_BAD_REQUEST);
   }  

}//end if for checking is not empty

else
      {
        $this->response([
          'status'=>FALSE,
          'message'=>' Please fill the valid data.'


        ],REST_Controller::HTTP_BAD_REQUEST);

}//end else part for checking is not empty
      

} //end methd fun

//======================================================================================================================//
public function Datalist_post()
{


       $alldata=$this->common_model->get_all_entries('master_reminders_type',array( 'sort'  => 'id',
      'sort_type' => 'DESC'));
       
        $this->response($alldata,REST_Controller::HTTP_OK);
      

} //end methd fun

}
?>
