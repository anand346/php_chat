<?php
session_start();
include 'config.php';
if(isset($_SESSION['username'])){
  header("location:{$hostname}/chat room/index.php");
}

  $username = htmlentities($_POST['username']);
  $password = md5(htmlentities($_POST['password']));
  $email = htmlentities($_POST['email']);
$sql = "SELECT * FROM registration WHERE username = '{$username}' OR email = '{$email}'";
  $result = mysqli_query($conn,$sql);
  if(mysqli_num_rows($result) > 0){
    $output = 2;
       }else{
         $sql1 = "INSERT INTO registration(username,password,email) VALUES('{$username}','{$password}','{$email}')";
         if(mysqli_query($conn,$sql1)){
           $output = 1;
         }else{
           $output = 0;
         }
      }
      mysqli_close($conn);
      echo $output;



?>
