<!DOCTYPE html>
<?php session_start(); ?>
<html>
      <head>
          <title>Social Network</title>
          <link rel="stylesheet" href="includes/styles/styles.css"/>
          <script src="includes/jquery/jquery.js"></script>
      </head>
<body>
     <div id="page" >

       <div id="header">
             <div class="logo">
               Social Network
             </div>
             <div class="nav">
                    <?php if(!isset($_SESSION['members_id']) or $_SESSION['members_id']=='' ){ ?>
                              <ul>
                                 <a href="login.php"><li>Login</li></a>
                                 <a href="signup.php"><li>Register</li></a>
                              </ul>

                       <?php
                        }else {
                        ?>
                               <ul>
                                   <a href="index.php"><li>Home</li></a>
                                   <a href="user.php?name=<?=$_SESSION['name'];?>"><li>TimeLine</li></a>
                                   <a href="notifications.php"><li>Notifications</li></a>
                                   <a href="profile.php"><li>Profile</li></a>
                                   <a href="message.php"><li>Messages</li></a>
                                   <a href="logout.php"><li>Logout</li></a>
                              </ul>

                      <?php
                        }
                    ?>

             </div>

             <div class="clear"></div>

       </div>
