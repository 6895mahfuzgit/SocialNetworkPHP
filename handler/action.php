<?php
include("../includes/config.php");

session_start();

  if($_REQUEST['action']=='sendFriendRequest'){

       $name=$_REQUEST['name'];
              $userIdSql=mysqli_query($db,"select id FROM members where name='$name' ");
              $userIdArray=mysqli_fetch_array($userIdSql);
       $sendingTo=$userIdArray['id'];
       $sendingBy=$_SESSION['members_id'];



        $request=mysqli_query($db,"INSERT INTO requests SET sendingto='$sendingTo',sendingfrom='$sendingBy',date_added=NOW() ");

        $message =$_SESSION['name']." Send You Friend Request";
        $request=mysqli_query($db,"INSERT INTO  notifications SET noti_from='$sendingBy',noti_to='$sendingTo',message='$message',date_added=NOW() ");




        echo "success";

  }

 ?>
