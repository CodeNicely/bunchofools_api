<?php

error_reporting(E_ALL); ini_set('display_errors', 1);

//CONTACT us api


include "database.php";

$dbObj = new Database;

$result = array();


if($result = $dbObj->pdo_read_last('contact_us' , 'id')) {

$result['success'] = true;
$result['message'] = "success";


} else  {  $result['success'] = false;  $result['message'] = "Failed to fetch from database.";}
$result = json_encode($result,JSON_UNESCAPED_SLASHES);

header("Content-type: application/json");

echo $result;