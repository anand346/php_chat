<?php
session_start();
include "config.php";
if(isset($_SESSION['username'])){
  header("location:{$hostname}/chat room/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-home.css">
  <title>Login and registration page</title>
</head>
<body>
  <header>
    <div class="heading">
      <h2>Login and Registration page</h2>
    </div>
  </header>
  <section>
    <div class="login">
      <input type="text" name="username" id="login-username" placeholder = "username here"><br>
      <input type = "password" placeholder = "password here" name = "password" id = "login-password"><br>
      <input type="submit" value="Login" id = "login-submit"><br>
      <p>Don't have an account? <a href="register.php" class = "login1">register here</a></p>
    </div>
    <div class="register">
        <input type="text" name="username" id="register-username"  placeholder = "username here"><br>
        <input type = "password" placeholder = "password here" name = "password" id = "register-password"><br>
        <input type = "password" placeholder = "confirm password here" name = "confirm-password" id = "register-password-2"><br>
        <input type="email" name="email" id="register-email" placeholder = "enter your email here"><br>
        <input type="submit" value="Register" id = "register-submit"><br>
        <p>Already have an account? <a href="login.php" class = "register1">Login here</a></p>
    </div>
  </section>
  <script src="js/jquery.js"></script>
  <script>
    $(document).ready(function(){
      $(".login").show();
      $(".register").hide();
      $(".login1").on("click",function(e){
        e.preventDefault();
        $(".login").hide();
        $(".register").show();
      })
      $(".register1").on("click",function(e){
        e.preventDefault();
        $(".login").show();
        $(".register").hide();
      })
      //registration starts here
      $("#register-submit").on("click",function(){
        var username = $("#register-username").val();
        var password = $("#register-password").val();
        var password2 = $("#register-password-2").val();
        var email = $("#register-email").val();
        if(username == "" || password == "" || password2 == "" || email == ""){
          alert("all fields are required");
        }else if(password != password2){
          alert("password and confirm password are not same");
        }else{
          $.ajax({
            url : "register.php",
            type : "POST",
            data : {username : username,password : password,email : email },
            success : function(data){
              if(data == 1){
                $(".register input[type = text],input[type = password],input[type = email]").val("");
                alert("registration done successfully");
                location.reload();
              }else if(data == 2){
                alert("username or email had already taken,please choose another one");
              }else{
                alert("registration failed");
              }

            }
          })
        }
      })
      //registration ends here

      //login starts here
      $("#login-submit").on("click",function(){
        var username = $("#login-username").val();
        var password = $("#login-password").val();
        if(username == "" || password == ""){
          alert("all fields are required");
        }else{
          $.ajax({
            url : "login.php",
            type : "POST",
            data : {username : username,password :password},
            success : function(data){
              if(data == 1){
                window.open("http://localhost/web dev/project 7/chat room/","_self");
              }else{
                alert("username or password is incorrect");
              }
            }
          })
        }
      })
      //login ends here
    })
  </script>
</body>
</html>