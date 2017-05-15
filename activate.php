<?php

   include("includes/config.php");

   $token=$_REQUEST['token'];

  $select=mysqli_query($db,"SELECT * FroM members where token='$token'");

   if(mysqli_num_rows($select)==1){
     $update=mysqli_query($db,"update members SET activated='1' where token=$token'");
     echo "Your Account is Activated";
   }
   else {
     echo "Please Try Again to Activate Your Account";
   }

   echo mysqli_error($update);
 ?>
