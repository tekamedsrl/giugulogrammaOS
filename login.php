<?php
/*
Developer:  Ehtesham Mehmood
Site:       PHPCodify.com
Script:     Angularjs Login Script using PHP MySQL and Bootstrap
File:       login.php
*/
 
//include database connection file
require_once 'db_config.php';
 
 
// verifying user from database using PDO
$stmt = $DBcon->prepare("SELECT user_email, user_password from user WHERE user_email=? && user_password=?");
//$stmt = $DBcon->prepare("SELECT user_email, user_password from user WHERE user_email='".$_POST['user_email']."' && user_password='".$_POST['user_password']."'");


$stmt->execute([$_POST['user_email'] ,$_POST['user_password']] );


//$stmt->execute();
$row = $stmt->rowCount();
$stmt = null;
if ($row > 0){
    session_start();
    $_SESSION['user']=$_POST['user_email'];
    $_SESSION['validated']=true;
    echo "correct";
} else{
    $_SESSION['validated']=false;
    echo 'wrong';
}
 
?>
