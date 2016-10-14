<?php

error_reporting(E_ALL); ini_set('display_errors', 1);

//About us api


include "database.php";

$dbObj = new Database;

$result = array();


if($result = $dbObj->pdo_read_last('about_us' , 'id')) {

$result['success'] = true;




} else  {  $result['success'] = false; }
$result = json_encode($result);

header("Content-type: application/json");

echo $result;