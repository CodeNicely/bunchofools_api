<?php

error_reporting(E_ALL); ini_set('display_errors', 1);

$name = (isset($_POST['name'])) ? $_POST['name'] : null;
$mobile = (isset($_POST['mobile'])) ? $_POST['mobile'] : null;
$email = (isset($_POST['email'])) ? $_POST['email'] : null;
$errors = 0;


if($name==null || $mobile==null || $email==null) {
    
    $errors++;
    $message = "All fields are required.";
    
} else {
    
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors++;
        $message = "Please provide vaild email.";
    }
    
    
}


if($errors==0) {
    
    $success = true;
    $message = "your request has been registered.";
    
} else {
    $success = false;
    
}






if($success == true) {
   include "database.php";
   $dbObj = new Database;
   
   $insert_array = array(
   "name" => "$name" , "mobile" => "$mobile" , "email" => "$email"
    );
    
  

   if($dbObj->pdo_insert('join_us',$insert_array)) {
   

} else {
 $success = false;
   
    $message = "Failed To insert in database. Please try again.";
    $message_display = $message;
  

}

 }
 
$message_display = (isset($message)) ? $message : "Debug message not set :D" ;
 
 $json = array(
    "success" => $success ,
    "message_display" => $message_display,
    "message" => $message
);





$json = json_encode($json);

header("Content-type: application/json");

echo $json;