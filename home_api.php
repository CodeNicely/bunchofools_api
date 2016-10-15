<?php

error_reporting(E_ALL); ini_set('display_errors', 1);

function curl_helper($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_URL, $url);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

$return = array();


//Slider data

include 'database.php';
$dbObj = new Database;

if($slider_data = $dbObj->pdo_read('slider_data')) { $return['success'] = true; } else { $return['success'] = false; }

$return['slider_data'] = $slider_data;


// Facebook Feeds.

$page_ID = '822748944431650';
$limit = 20;

$access_token = '{access-token}'; //Important!!!! -- do not use user token. user tokens get expired. Use app tokens, they do not expire

if($json = curl_helper('https://graph.facebook.com/'.$page_ID.'/posts?fields=attachments&limit='.$limit.'&access_token='.$access_token)) {
$return['message'] = "success";

$return['feeds'] = json_decode($json);;

} else { $return['message'] = "fail"; }



$return = json_encode($return , JSON_UNESCAPED_SLASHES);





header("Content-type: application/json");

echo $return;

