<?php
include 'config.php';
ob_start();
 session_start();
// if(isset($_SESSION['username'])){
  // header("location:{$hostname}/chat room/index.php");
// }
$username = htmlentities($_POST['username']);
$password = md5(htmlentities($_POST['password']));
// if($username == "" or $password == ""){
	// echo "please enter your username and password";
// }
 $sql = "SELECT * FROM registration WHERE username = '{$username}' AND password = '{$password}'";
 $result = mysqli_query($conn,$sql);
if($result){
  $row = mysqli_fetch_assoc($result);
      $_SESSION['username'] = $row['username'];
      $_SESSION['id'] = $row['id'];
	  $output = 1;
	  // header("location:{$hostname}/chat/chat room/index.php");
}else{
 $output = 0;
}
echo $output;
ob_end_flush();
?>