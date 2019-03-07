<?php
/*
Developer:  Ehtesham Mehmood
Site:       PHPCodify.com
Script:     Angularjs Login Script using PHP MySQL and Bootstrap
File:       db_config.php
*/
$DB_host = "localhost";
$DB_user = "web";
$DB_pass = "grigio";
$DB_name = "angularjsloginscript";
//Connect with database
 try
 {
     $DBcon = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DBcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOException $e)
 {
     echo "ERROR : ".$e->getMessage();
 }
 
 ?>
