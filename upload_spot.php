<?php

/***
*@ UPLOAD SPOT API
*@ Version 0.1
*@ The Variables are vulnerable for time being
***/

$name = (isset($_POST['name'])) ? $_POST['name'] : null;
$mobile = (isset($_POST['mobile'])) ? $_POST['mobile'] : null;
$image = (isset($_FILES['image']['name'])) ? $_FILES['image']['name'] : null;
$location = (isset($_POST['location'])) ? $_POST['location'] : null;
$email = (isset($_POST['email'])) ? $_POST['email'] : null;
$errors = 0;


if($name==null || $mobile==null || $image==null || $location==null || $email==null) {
    $errors++; 
    $message = "Error occured. All fields are required.";
    
} else {
    
    //Validation starts here.. Go from bottom to top :D
    
    //Email Validation
    
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors++;
        $message = "Invaild email address";
    }
    //Do some more validation
    
    
   //Image Validation


    $target_dir = "UploadedSpotsImages/";


    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $time = time();


    $target_file = $target_dir.md5($time).".$imageFileType";
    $uploadOk = 1;


    // Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
    
        $uploadOk = 0;
        $errors++;
        $message = "Error while uploading. Fake Image.";
    }

    // Check if file already exists
    if (file_exists($target_file)) {
    $uploadOk = 0;
    $errors++;
    $message = "File already exist";
    }
    // Check file size
    if ($_FILES["image"]["size"] > 25*1024000) {
    $uploadOk = 0;
    $errors++;
    $message = "Image file too large. (More than 25 Mb)";
    } 
    // Allow certain file formats
    
    //type to lower case
    
    $imageFileType = strtolower($imageFileType);
    
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    $errors++;
    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    $errors++;
        //    echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {

    if($errors==0) {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $message = "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
        } else {
        $errors++;
        $message = "There was some error in uploading image";
        //some error while uploading
            }
        }  
        
    }
    
}


    if($errors==0) {
    $success = true;
    $message_display = "spot has been registered,executive will contact you shortly";
    } else {
    $success = false;
    $message_display = (isset($message)) ? $message : "Error occured. All fields are required.";
    }

    if($success==true) {

        $image_n = md5($time).".$imageFileType";

        $insert_array = array(
            "name" => "$name" , "mobile" => "$mobile" , "image" => "$image_n" , "location" => "$location" , "email" => "$email"
        );
        include "database.php";
        $dbObj = new Database;
        if($dbObj->pdo_insert('upload_spot',$insert_array)) {
                //Do nothing or something :D
        } else { $success = false; $message = "Error occured. Please try again"; $message_display = $message; }

    }

    $json = array(
    "success" => $success ,
    "message_display" => $message_display ,
    "message" => $message

    );

    $json = json_encode($json);

    header("Content-type: application/json");
    echo $json;



