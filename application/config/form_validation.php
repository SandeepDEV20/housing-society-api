<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config = array(

    /* ======== Visitor Module =============== */
    'api_list_visitors' => array(

    ),
    'api_create_new_visiting_request' => array(
        array(
            'field' => 'fk_visitor_id',
            'label' => 'Visitor ID',
            'rules' => 'required|trim|callback_validateVisitorId'
        ),
        array(
            'field' => 'fk_visit_person_id',
            'label' => 'Visit Person Id',
            'rules' => 'required|trim|callback_validateUserId'
        ),
        array(
            'field' => 'purpose',
            'label' => 'Purpose',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'in_time',
            'label' => 'In Time',
            'rules' => 'trim'
        ),
        array(
            'field' => 'out_time',
            'label' => 'Out Time',
            'rules' => 'trim'
        ),
        array(
            'field' => 'vehicle_detail',
            'label' => 'Vehicle Detail',
            'rules' => 'trim'
        ),
        array(
            'field' => 'api_key',
            'label' => 'API Key',
            'rules' => 'required|trim|callback_validateAPIKey'
        ),
        array(
            'field' => 'create_by',
            'label' => 'Create By',
            'rules' => 'required|trim|callback_validateUserId'
        ),
        
    ),
    'api_create_new_visitor' => array(
        
        array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim'
        ),
        array(
            'field' => 'mobile',
            'label' => 'Mobile Number',
            'rules' => 'required|trim|numeric|exact_length[10]'
        ),
        array(
            'field' => 'otp_verification_status',
            'label' => 'OTP Verification Status',
            'rules' => 'trim|in_list[0,1]'
        ),
        array(
            'field' => 'alternate_contact',
            'label' => 'Alternate Contact',
            'rules' => 'trim'
        ),
        array(      
            'field' => 'address_line1',
            'label' => 'Address Line 1',
            'rules' => 'trim'
        ),
        array(      
            'field' => 'address_line2',
            'label' => 'Address Line 2',
            'rules' => 'trim'
        ),
        array(      
            'field' => 'address_line3',
            'label' => 'Address Line 3',
            'rules' => 'trim'
        ),
        array(      
            'field' => 'fk_city_id',
            'label' => 'City ID',
            'rules' => 'trim|numeric'
        ),
        array(      
            'field' => 'pin_code',
            'label' => 'Pin Code',
            'rules' => 'trim|numeric|exact_length[6]'
        ),
        array(
            'field' => 'api_key',
            'label' => 'API Key',
            'rules' => 'required|trim|callback_validateAPIKey'
        ),
        array(
            'field' => 'create_by',
            'label' => 'Create By',
            'rules' => 'required|trim|callback_validateUserId'
        ),
        array(
            'field' => 'save_in_time',
            'label' => 'Save In Time',
            'rules' => 'required|trim|in_list[YES,NO]'
        ),
    ),
    'api_update_visitor' => array(

    ),
    'api_block_unblock_visitor' => array(

    ),

    /* ======== Create/Enable/Disable Module ==== */

    'api_create_new_module' => array(
        array(
            'name' => 'name',
            'label' => 'Name',
            'rules' => 'required|trim'
        ),
        array(
            'user_id' => 'user_id',
            'label' => 'User Id',
            'rules' => 'required'
        ),
    ),
    'api_module_enable_disable' => array(
        array(

            'id' => 'id',

            'label' => 'Module Id',

            'rules' => 'required|trim'

        ),

        array(

            'user_id' => 'user_id',

            'label' => 'User Id',

            'rules' => 'required'

        ),

    ),



    /* ======== Send Notification ==== */

    'api_send_email' => array(



    ),



    /* ========= Login ======== */

    'api_login' => array(

        array(

            'field' => 'user_name',

            'label' => 'User Name',

            'rules' => 'required'

        ),

        array(

            'field' => 'password',

            'label' => 'Password',

            'rules' => 'required'

        ),

    ),

    'api_upload_new_files' => array(



        /*array(

           'field' => 'uid',

            'label' => 'User ID',

            'rules' => 'required|trim|callback_validate_user_id'

        ),

        array(

           'field' => 'api_key',

            'label' => 'API KEY',

            'rules' => 'required|trim|callback_validate_api_key'

        ),*/

        array(

            'field' => 'userfiles',

            'label' => 'File',

            'rules' => 'callback_validateFile'

        ),

        array(

            'field' => 'upload_path',

            'label' => 'Upload Path',

            'rules' => 'required'

        ),

    ),

// ===============================Master Occupations ==========================================//
    'api_create_new_occupation'=>array(
                array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|trim'),

            array(
             'field'=>'description',
             'lable'=>'Description',
              'rules'=>'required|trim'),

                  
                array(
             'field' => 'create_by',
            'label' => 'Create By',
            'rules' => 'required|trim|callback_validateUserId'),

            array(
             'field' => 'api_key',
            'label' => 'api_key',
            'rules' => 'required|trim|callback_validateAPIKey'),

        ),



         'api_update_occupation_detail'=>
         array(
                array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim'),

            array(
             'field'=>'description',
             'lable'=>'Description',
              'rules'=>'required|trim'),

                  
                array(
             'field' => 'create_by',
            'label' => 'Update By',
            'rules' => 'required|trim|callback_validateUserId'),

            
            array(
             'field' => 'api_key',
            'label' => 'api_key',
            'rules' => 'required|trim|callback_validateAPIKey'),

        ),

         'api_occupation_status'=>
         array(
            array(
             'field'=>'id',
             'lable'=>'ID',
             'rule'=>'required|trim'),
            
            array(
                'field'=>'status',
                'lable'=>'Status',
                  'rule'=>'required|trim'),

                     array(
             'field' => 'api_key',
            'label' => 'api_key',
            'rules' => 'required|trim|callback_validateAPIKey'),
        ),
);