<?php
     include('header.php');
     include("includes/config.php");
?>
    <h1>
         <?php
             $name=$_REQUEST['name'];

             $sqlForMemberInfo=mysqli_query($db,"select * FROM members where name='$name'");
             $memberInfo=mysqli_fetch_array($sqlForMemberInfo);

             $sqlForProfileInfo=mysqli_query($db,"select * FROM profile where user_id='".$memberInfo['id']."'");
             $userInfo=mysqli_fetch_array($sqlForProfileInfo);


          ?>
    </h1>

    <div class="userInfo">
          <table width="100%" >
             <tr>
                  <td width="5%">
                    <?php
                          if(!isset($userInfo['pic'])){
                            echo "<H1>No Profile Pic</H1>";
                          }
                          else {
                     ?>
                              <img src="uploads/<?=$userInfo['pic'];?>" width="150px" height="150px" class="pic" />
                    <?php
                              }
                    ?>

                  </td>
                  <td width="95%" valign="top"><?=$memberInfo['name'];?></td>
             </tr>
             <tr>
                  <td width="5%">Email</td>
                  <td width="95%"><?=$memberInfo['email'];?></td>
             </tr>
             <tr>
                  <td width="5%">Country</td>
                      <?php
                          $countrySql=mysqli_query($db,"SELECT * FROM countries where id= '".$userInfo['country']."'");
                          $countryName=mysqli_fetch_array($countrySql);
                       ?>
                  <td width="95%"><?= $countryName['country_name'];?></td>
             </tr>
             <tr>
                  <td width="5%">Gender</td>
                      <?php
                        if($userInfo['gender']=='m'){
                           $gender="Male";
                        }
                        else if ($userInfo['gender']=='f') {
                          $gender="Female";
                        }else {
                          $gender="-";
                        }
                       ?>
                  <td width="95%"><?=$gender;?></td>
             </tr>
             <tr>
                  <td width="5%">About</td>
                  <td width="95%"><?=$userInfo['about'];?></td>
             </tr>
             <tr>
                  <td width="5%">Date Of Birth</td>
                  <td width="95%"><?=$userInfo['dob'];?></td>
             </tr>
             <tr>
                  <td   colspan="2" >
                         <?php
                              $sendingTo=$memberInfo['id'];
                              $sendingBy=$_SESSION['members_id'];

                                $request=mysqli_query($db,"Select * FROM requests where sendingto='$sendingTo' and sendingfrom='$sendingBy' and accepted='0'");
                               if( mysqli_num_rows($request)>=1){
                                 echo "Friend Request Send";
                               }
                               else {
                                    if($memberInfo['id']!=$_SESSION['members_id']){


                          ?>
                          <input type="button" value="Send Friend Request" class="btn" onclick="SendAction(1,'<?=$name;?>')" id="sendingRequestBtn" ></input>
                          <?php
                                       }
                               }
                          ?>


                  </td>

             </tr>
          </table>
    </div>
    <div class="posts">
         <form id="statusFrm" name="statusFrm" method="post">
               <table  width="100%">
                     <tr>
                         <td>
                              <textarea name="status" class="required" rows="6" style="width:98%;" cols="30%"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td>
                            <input type="submit" value="Post Status" />
                         </td>
                     </tr>
               </table>
         </form>

        <div id='allPosts'>
           Loading............
        </div>

    </div>

<script>

 $(document).ready(function(){
      loadPosts();
 });


  function SendAction(type,name){

    $.post('handler/action.php?action=sendFriendRequest&name='+name,function(response){

       if(response=="success"){
          $('#sendingRequestBtn').hide();
          $('#sendingRequestBtn').parent().html("Friend Request Send");
        }
    });
  }

  $('#statusFrm').validate({

      submitHandler:function(form){

        $.post('handler/action.php?action=savePost&user_id='+<?=$memberInfo['id'] ?>,$('#statusFrm').serialize(),function showInfo(responseDate){

                if(responseDate == "Success.........!!!"){
                  loadPosts();
                   document.getElementById('statusFrm').reset();
                }
              alert(responseDate);
        });
      }

    });

function loadPosts(){
        $.post('handler/action.php?action=FetchPosts&user_id='+<?=$memberInfo['id'] ?>,function(responseData){
               $('#allPosts').html(responseData);

        });
}

function LoadComment(postid){
      $.post('handler/action.php?action=LoadAllComments&post_id='+postid,function(responseData){
          $('#allcomments_'+postid).html(responseData);
            $('#viewcomment_'+postid).hide();
      });
}

</script>

<?php include('footer.php');?>
