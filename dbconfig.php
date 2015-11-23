<?php
//print_r (session_start());
session_start();
session_regenerate_id(true);

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

include 'class/class.user.php';
include 'class/class.projects.php';
include 'class/class.variables.php';

$user = new USER($DB_con); 
$variables = new VARIABLES($DB_con); 
$projects = new PROJECTS($DB_con); 