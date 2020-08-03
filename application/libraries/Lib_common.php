<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_common extends CI_Controller {
	 
    private $CI;

    function __construct()
    {
      $this->CI = get_instance();
    }
    
    function isValidUser($create_by){
      
      $info = $this->CI->common_model->get_entry_by_data('users',true,array('id' => $create_by ),'id');
      if(!empty($info))
        return true;

      return false;
    } // End Function

    function isValidAPIKey($create_by, $api_key){
      
      $info = $this->CI->common_model->get_entry_by_data('users',true,array( 'id' => $create_by, 'api_key' => $api_key ),'id');
      
      if(!empty($info))
        return true;

      return false;
      
    } // End Function

    function uploadFiles($userfiles,$path){

          $len = count($userfiles['name']);
          $allowedfileExtensions = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'doc', 'DOC', 'docx', 'DOCX', 'pdf', 'PDF', 'eml', 'EML', 'csv', 'ppt', 'pptx', 'zip', 'msg','xls','xlsx','csv' );

          $message = [];

          for($i = 0; $i < $len; $i++){

            $fileTmpPath = $userfiles['tmp_name'][$i];
            $fileName = $userfiles['name'][$i];
            $fileSize = $userfiles['size'][$i];
            $fileType = $userfiles['type'][$i];

            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $message[$i]['filename'] =    $fileName;

            if (in_array($fileExtension, $allowedfileExtensions)) {

                  
                  $uploadFileDir = $path;
                  $dest_path = FCPATH.$uploadFileDir.$fileName;
                  
                  if(move_uploaded_file($fileTmpPath, $dest_path))
                  {
                      $message[$i]['is_uploaded'] = "YES";
                  }
                  else
                  {
                      $message[$i]['is_uploaded'] = "NO";
                      
                  }

            } // End IF Check File Extension
            else{
              $message[$i]['is_uploaded'] = "NO";
            }

            $message[$i]['error'] = isset($userfiles['error'][$i]) ? $userfiles['error'][$i] : NULL;
          } // End For Loop


          return $message;
             
    } // End Function

    function callAPIBasicAuth(){

      $login = 'tlc0nn3ctf0rt3wdl';
      $password = 'telesonic##0098';
      $url = 'https://ltesd.telesonic.in:8443/tmsapp_api/v1/connected_device';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
      
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, '{"serial": "T5D7S18320913971"}');
      curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json','key: 64df95454c3f4f0896647a2d01cbef15')); 


      $result = curl_exec($ch);
      curl_close($ch);  

      pr(json_decode($result));

  } // End Function

  function callAPI($method, $url, $data){
              
      $curl = curl_init();

       switch ($method){

      //case "GET":
      //curl_setopt($curl, CURLOPT_GET, 1);
      //break;
        
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
      }

       // OPTIONS:
       curl_setopt($curl, CURLOPT_URL, $url);
       // curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       //    'Content-Type: application/json',
       // ));

       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

       // EXECUTE:
       $result = curl_exec($curl);
       
       //pr($result); die;

       if(!$result){ die("Connection Failure"); }
       curl_close($curl);
       return $result;

  } // End Function

} // End Class