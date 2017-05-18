<?php
     include('header.php');
     include("includes/config.php");
?>

<div class="friendslist">

     <h1>Friends</h1>
      <?php

             $friends=mysqli_query($db,"SELECT * From friends where
                                   user1='".$_SESSION['members_id']."' or user2='".$_SESSION['members_id']."' ");
            echo $totalFriends=mysqli_num_rows($friends);


           while($result=mysqli_fetch_array($friends)){
      ?>
                 <div class="notification">

                      <?php

                        if($result['user1']!=$_SESSION['members_id']){

                             $userNameSQL=mysqli_query($db,"SELECT * FROM members where id='".$result['user1']."' ");
                             $userPicSQL=mysqli_query($db,"SELECT * FROM profile where user_id='".$result['user1']."' ");

                             $userName=mysqli_fetch_array($userNameSQL);
                             $userPic=mysqli_fetch_array($userPicSQL);

                               if(mysqli_num_rows($userPicSQL)==0){
                                 echo ' <img src="uploads/default.jpg" width="150px" height="150px" class="pic" />'.$userName['name'];
                               }
                               else {
                                    echo ' <img src="uploads/'.$userPic['pic'].'" width="150px" height="150px" class="pic" />'.$userName['name'];
                               }

                        }
                        if($result['user2']!=$_SESSION['members_id']){

                             $userNameSQL=mysqli_query($db,"SELECT * FROM members where id='".$result['user2']."' ");
                             $userPicSQL=mysqli_query($db,"SELECT * FROM profile where user_id='".$result['user2']."' ");

                             $userName=mysqli_fetch_array($userNameSQL);
                             $userPic=mysqli_fetch_array($userPicSQL);

                             if(mysqli_num_rows($userPicSQL)==0){
                               echo ' <img src="uploads/default.jpg" width="150px" height="150px" class="pic" />'.$userName['name'];
                             }
                             else {
                                  echo ' <img src="uploads/'.$userPic['pic'].'" width="150px" height="150px" class="pic" />'.$userName['name'];
                             }
                        }

                       ?>

                       (<?=$result['date_added'];?>)

                 </div>
      <?php
           }
       ?>
</div>


<div class="notificationlist">
  <h1>Requests</h1>
  <?php

        $userId=$_SESSION['members_id'];

        $notificationSql=mysqli_query($db,"select * from notifications where noti_to=' $userId'");

         while($rest=mysqli_fetch_array($notificationSql)){

              $friends=mysqli_query($db,"SELECT * From friends where
                                         (user1='".$rest['noti_to']."' and user2='".$rest['noti_from']."')
                                          or
                                         (user2='".$rest['noti_to']."' and user1='".$rest['noti_from']."'   )
                                  ");

        if(mysqli_num_rows($friends)<1){
   ?>
               <div class="notification">
                    <?=$rest['date_added'];?>
                      _____
                    <?=$rest['message'];?>
              </div>
   <?php
           }
   ?>

   <?php
   }
   ?>

</div>


<script>


   $('.actionBtn').click(function(){

    ActionBtn=$(this);
    var type=ActionBtn.attr('data-type');
    var user=ActionBtn.attr('data-user');

              $.post('handler/action.php?action=RequestHandalingType&type='+type+'&from='+user,function(response){
                     //alert(response);
                  if(response=='Acceped Succesfully !!!'){
                          ActionBtn.parent().html('You and '+user+'Are Now Friends.');
                  }
                  else if(response=='Rejected ???') {
                          ActionBtn.parent().html('You Have Rejected The Friend Request');

                  }
             });



  });

</script>

<?php include('footer.php');?>
