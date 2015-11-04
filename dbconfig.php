<?php

session_start();

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "root";
$DB_name = "project";

try {
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
     echo $e->getMessage();
}

include_once 'class.user.php';
include_once 'class.variables.php';
$user = new USER($DB_con); 
$variables = new VARIABLES($DB_con); 
