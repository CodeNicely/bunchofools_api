<?php

error_reporting(E_ALL); ini_set('display_errors', 1);

//Gallery API

$image_dir = "GalleryImages";

if($get_images = glob("$image_dir/*")) {
$success = true;
$message = "Images available!";

} else {
$success = false;
$message = "Some error occured.";
$get_images = array();
}


$get_images = array_map( "full_url" , $get_images);


function full_url($v) {
return "http://android.bunchofools.com/$v";

}


$json =  array(
 "success" => $success , "message" => $message , "gallery_images" => $get_images
);

$json = json_encode($json, JSON_UNESCAPED_SLASHES);

header("Content-type: application/json");

echo $json;