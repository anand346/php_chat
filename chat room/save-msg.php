<?php
session_start();
if(!(isset($_SESSION['username']))){
  header("location:{$hostname}/index.php");
}
include "../config.php";
$fromuser = $_POST['fromuser'];
$touser = $_POST['touser'];
$message = htmlentities($_POST['message']);
if($_SESSION['id'] == $fromuser){
	function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$ip =  get_client_ip();
 $sql = "INSERT INTO messages(fromuser,touser,message,ip) VALUES('{$fromuser}','{$touser}','{$message}','{$ip}')";
if(mysqli_query($conn,$sql)){
  //header("location:{$hostname}/chat room/index.php?touser='{$touser}'");
echo 1;
}else{
  echo 0;
}
}else{
  header("location:{$hostname}/chat room/index.php?touser='{$touser}'");
}
?>