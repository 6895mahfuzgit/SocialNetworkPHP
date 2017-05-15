<?php
     include('header.php');
     session_start();
?>

   <h1>
    <?php
        echo "SESSION ID:".$_SESSION['members_id'];
        echo "\nSESSION NAME".$_SESSION['name'];
     ?>
   </h1>

    <a href="logout.php">LogOut</a>
<?php include('footer.php');?>
