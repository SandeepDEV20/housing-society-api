<?php

if( !function_exists('isValidDate') ){

	function isValidDate($str_date){ 
		
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str_date)) {
    		return true;
		} 
		else {
    		return false;
		}
	} 

} // End Helper Function

if( !function_exists('isValidEmail') ){

	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
}

if(!function_exists('short_date_format')){
	
	function short_date_format($params)
	{
	   $date = new DateTime($params);
       $date = $date->format('d-M-y');

       return $date;

	   /*$date = date('d-M-y', strtotime($params));
	   return $date;*/
	}	

} // End Helper Function 

if(!function_exists('array_has_duplicates')){
	
	function array_has_duplicates($array) {
   		return count($array) !== count(array_unique($array));
	}

} // End Helper Function



if(!function_exists('short_date_format_ampm')){

	function short_date_format_ampm($params) 
	{       
		if($params == NULL)
	    	return NULL;
	       
		$date = date('d-M-y h:i A', strtotime($params));	   
		return $date; 

	}

} // End Helper Function 

function id_decode($id){
	$id = $id . str_repeat('=', strlen($id) % 4); #create complete base64 code.
	$id = substr(base64_decode($id),6); # decode & remove salt from the start.
	$decoded_id = substr($id,0,-6); # remove salt from the end.
	return $decoded_id;
}

function id_encode($id){
	
	$encoded_id = rtrim(base64_encode(SALT.$id.SALT),'='); # add salt in id, convert it into base64 and remove == from base64 id
	return $encoded_id;
}


if(!function_exists('pr')){
	
	function pr($arg)
	{
		 echo "<pre>";
		 print_r($arg);
		 echo "<pre>";
	}

} // End Helper Function 

