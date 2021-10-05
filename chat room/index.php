<?php
include "../config.php";
session_start();
 if(!(isset($_SESSION['username']))){
   header("location:{$hostname}/index.php");
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body>
  <header>
    <div class="content">
      <h2>Chat room , hello <?php echo $_SESSION['username'];?></h2>

    </div>
  </header>
  <section class="banner">
    <div class="users-list">
      <?php

      $sql = "SELECT * FROM registration WHERE NOT id = {$_SESSION['id']}";
      $result = mysqli_query($conn,$sql) or die("sql failed");
      if(mysqli_num_rows($result) > 0){
      ?>
      <ul>
        <?php
          while($row = mysqli_fetch_assoc($result)){
        ?>
        <li><a href="index.php?touser=<?php echo $row['id']?>"><?php echo $row['username'];?></a></li>
        <?php
          }
          echo "</ul>";
        }
        ?>
    </div>
    <?php
    if(isset($_GET['touser'])){
      $_SESSION['touser'] = $_GET['touser'];
    }else{
      $_SESSION['touser'] = 1;
    }
      if(isset($_SESSION['touser'])){
        $touserid = $_SESSION['touser'];
      $sql2 = "SELECT * FROM registration WHERE id = {$touserid}";
      $result2 = mysqli_query($conn,$sql2);
      if(mysqli_num_rows($result2) > 0){
        $row2 = mysqli_fetch_assoc($result2);
      ?>
    <div class="chat-box">
      <div class="tousername"><h2><?php echo $row2['username'];?></h2></div>
      <div class="msgs">
      <?php
        //   $sql1 = "SELECT * FROM messages WHERE fromuser IN( {$_SESSION['id']},{$touserid})  AND touser  IN ({$_SESSION['id']},{$touserid})";
        // $result1 = mysqli_query($conn,$sql1);
        // if(mysqli_num_rows($result1) > 0){
        //  while($row1 = mysqli_fetch_assoc($result1)){
      ?>
         <!-- <p> -->
         <?php
          // echo $row1['message'];
         ?>
        <!-- </p> -->
       <?php
      //  }
      // }
      ?>
      </div>
      <div class="send-msgs">
        <input type="text" name="fromuser" id="fromuserid" value = "<?php echo $_SESSION['id'];?>" hidden>
        <input type="text" name="touser" id="touserid" value = "<?php echo $touserid;?>" hidden>
        <form id = "addform">
        <!-- <form action = "save-msg.php" method = "POST"> -->
        <input type = "text" name = "msg" id = "msg" >
        <input type = "submit" id = "send" name = "send" value = "Send">
        </form>
        <!-- </form> -->
      </div>
    </div>
    <?php
    }
  }else{
    echo "plz click the user you want to send message";
  }
    ?>
    <div class="logout-section">
    <div class="user-details">
    <div class = "user-image"><img src="../images/images-user.png" alt=""></div>
      <?php
        $sql1 = "SELECT * FROM registration WHERE username = '{$_SESSION['username']}' ";
        $result1 = mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result1) > 0){
      ?>
      <ul>
        <?php
          while($row1 = mysqli_fetch_assoc($result1)){
        ?>
        <li><?php echo $row1['username'];?></li>
        <li><?php echo $row1['email'];?></li>
        <a href= "logout.php">Logout</a>
        <?php
          }
        ?>
      </ul>
      <?php
        }
      ?>
    </div>
    </div>
  </section>
  <div class="footer">
      <p> Copyright &copy 2021 Brought to you by Voldemort</p>
    </div>
  <script src = "jquery.js"></script>
  <script>
    // $(document).ready(function(){
    //   alert(1);
    //   setInterval(() => {
    //     refresh();
    //   }, 1000);
    // })
          $(document).ready(function(){
           //load messages
          //  setInterval(() => {
          //   $.ajax({
          //      url : 'show-messages.php',
          //      type : "POST",
          //      success : function(data){
          //        $(".msgs").html(data);
          //      }
          //    })
          //  }, 1000);

            function showMessages(){
              $.ajax({
                url : 'show-messages.php',
                type : "POST",
                success : function(data){
                  $(".chat-box .msgs").html(data);
                }
              })
              $(".chat-box .msgs").animate({scrollTop:10000000},600);
            }
            showMessages();

            setInterval(() => {
               $.ajax({
                 url : 'show-messages.php',
                 type : "POST",
                 success : function(data){
                   $(".chat-box .msgs").html(data);
                 }
              })
             }, 1000);


        //   //send messages
          //   var touserid = $("#touserid").val();
          //  var fromuserid = $("#fromuserid").val();
          //   var message = $("#msg").val();
          //   $("#send").on("click",function(e){
          //     e.preventDefault();
          //     if(message == ""){
          //     alert("message cant be empty");
          //     }else{
          //     $.ajax({
          //       url : "save-msg.php",
          //       type : "POST",
          //       data : {fromuser : fromuserid, touser : touserid, message : message},
          //       success : function(data){
          //         if(data == 1){
          //           showMessages();
          //         }
          //       }
          //     })
          //   }
          //   })
          $("#send").on("click",function(e){
            e.preventDefault();
           var touserid = $("#touserid").val();
            var fromuserid = $("#fromuserid").val();
             var message = $("#msg").val();
      // var fname = $("#fname").val();
      // var lname = $("#lname").val();
      if(message == ""){
        alert("message is empty");
      }else{
        $.ajax({
                 url : "save-msg.php",
                 type : "POST",
                 data : {fromuser : fromuserid, touser : touserid, message : message},
                 success : function(data){
                   if(data == 1){
                     showMessages();
                     $("#addform").trigger("reset");
                  }else{
                    showMessages();
                    alert("message not saved");
                    $("#addform").trigger("reset");
                  }
                 }
             })
      }

    });

          })
  </script>
</body>
</html>