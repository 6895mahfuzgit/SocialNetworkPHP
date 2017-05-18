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

                    //onclick='ActionRequest(2,".$sendingBy.")'

        $message =$_SESSION['name']." Send You Friend Request
                                    <input type='button' value='Accepted' class='actionBtn accepted' data-type='1' data-user='".$sendingBy."' /><input type='button' value='Rejected' class='actionBtn rejected' data-type='2' data-user='".$sendingBy."' />";

        $request=mysqli_query($db,"INSERT INTO  notifications SET noti_from='$sendingBy',noti_to='$sendingTo',message='".addslashes($message) ."',date_added=NOW() ");




        echo "success";

  }


  else if ($_REQUEST['action']=='RequestHandalingType'){


            if($_REQUEST['type']==1){

                     $requestUpdate=mysqli_query($db,"UPDATE requests SET accepted='1'  where sendingto='".$_SESSION['members_id']." ' and sendingfrom='".$_REQUEST['from']."' ");

                     $friends=mysqli_query($db,"INSERT INTO friends set id='',user1='".$_SESSION['members_id']." ',user2='".$_REQUEST['from']."',date_added=Now()");

                  if($requestUpdate and $friends ){
                       echo "Acceped Succesfully !!!";
                     }
            }
            elseif ($_REQUEST['type']==2) {
                     $requestUpdate=mysqli_query($db,"UPDATE requests SET accepted='2'  where sendingto='".$_SESSION['members_id']." ' and sendingfrom='".$_REQUEST['from']."' ");

                     if($requestUpdate ){
                          echo "Rejected ???";
                        }
            }




  }

 ?>
