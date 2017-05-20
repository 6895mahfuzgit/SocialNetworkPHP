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


  elseif ($_REQUEST['action']=='savePost') {

         $insertPostQuery=mysqli_query($db,"INSERT INTO posts SET id='',post_to='".$_REQUEST['user_id']."', user_id='".$_SESSION['members_id']."',status='".$_REQUEST['status']."',date_added=NOW() ");

          echo  "Success.........!!!";

  }

  else if ($_REQUEST['action']=='FetchPosts') {

       $Post='';
       if($_SESSION['members_id']==$_REQUEST['user_id']){
           $sql="SELECT * FROM posts where
                 user_id='".$_SESSION['members_id']."'
                 or post_to='".$_SESSION['members_id']."'
                 order by id desc ";
       }
       else{
         $sql="SELECT * FROM posts where
               user_id='".$_REQUEST['user_id']."'
               or post_to='".$_REQUEST['user_id']."'
               order by id desc ";

       }


       $getAllPostsOrTheUser=mysqli_query($db,$sql);



        while($post=mysqli_fetch_array($getAllPostsOrTheUser)){


                   $userPicSQL=mysqli_query($db,"SELECT * FROM profile where user_id='".$_SESSION['members_id']."'");

                      $userPic=mysqli_fetch_array($userPicSQL);

                   $userNameSQL=mysqli_query($db,"SELECT * FROM members where id='".$post['user_id']."'");
                      $userName=mysqli_fetch_array($userNameSQL);



                     if(isset($userPic['pic']) and $userPic['pic']!='' ){
                               $img='<img src="uploads/'.$userPic['pic'].'" width="150px" height="150px" class="pic" />';
                      }
                     else {
                             $img='<img src="uploads/default.jpg" width="150px" height="150px" class="pic" />';
                        }

          $anotherName='';
          if($post['post_to']!=0){
            $userNameSQL1=mysqli_query($db,"SELECT * FROM members where id='".$post['user_id']."'");
               $userName1=mysqli_fetch_array($userNameSQL1);
                 $anotherName='>'.$userName1['name'];

          }



          $Post .= '<div class="single-post">

                     <table width="100%" >
                            <tr>
                                <td width="10%" >'.$img.'</td>
                                <td width="90%" align="left" ><a href="user.php?name='.$userName['name'].'"> <h1>'.$userName['name'].'  </h1></a> '.$anotherName.'</td>
                            </tr>
                            <tr>
                                 <td colspan="2"><i>'.$post['status'].' </i></td>
                            </tr>
                            <tr align="right">
                                 <td colspan="2" >Posted on:'.$post['date_added'].'</td>
                            </tr>
                            <tr  >
                                 <td colspan="2"  align="right">
                                    <form   id="CommentFrm_'.$post['id'].'" method="POST">
                                          <input type="text" name="comment_'.$post['id'].'"></input>
                                          <input type="submit"></input>
                                    </form>
                                 </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">
                                    <a href=" javascript:void(0) id="viewcomment_'.$post['id'].'" onclick="LoadComment('.$post['id'].')" >View Posts</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">
                                     <div id="allcomments_'.$post['id'].'">
                                     <img src="uploads/loading.gif" height="200px" weight="200px"/>
                                     </div>
                                </td>
                            </tr>
                     </table>


                   <hr/>

                </div>
                <script>
                  $("#CommentFrm_'.$post['id'].'").validate({
                        submitHandler:function(form){

                        $.post("handler/action.php?action=CommentPosts&post_id='.$post['id'].'",$("#CommentFrm_'.$post['id'].'").serialize(),function showInfo(responseDate){

                            if(responseDate=="Success!"){

                              document.getElementById("CommentFrm_'.$post['id'].'").reset();
                              LoadComment('.$post['id'].');
                            }
                           alert(responseDate);
                        });
                      }

                  });

                </script>
                ';
        }

        echo $Post;

  }

  elseif ($_REQUEST['action']=='CommentPosts') {


        $postId=$_REQUEST['post_id'];
        $userId=$_SESSION['members_id'];
        $comment=$_REQUEST["comment_$postId"];

     mysqli_query($db,"INSERT INTO comments set id='',post_id='".$postId."',user_id='".$userId."', comment='".$_REQUEST["comment_$postId"]."', date_added=NOW()");
         echo 'Success!';
  }

  elseif ($_REQUEST['action']=='LoadAllComments') {

     $htmlComments='';

     $getCommentsSql=mysqli_query($db,"select * from comments where  post_id='".$_REQUEST['post_id']."' order by id desc");

     while($comment=mysqli_fetch_array($getCommentsSql)){

                   $userPicSQL=mysqli_query($db,"SELECT * FROM profile where user_id='".$comment['user_id']."'");

                   $userPic=mysqli_fetch_array($userPicSQL);

                   $userNameSQL=mysqli_query($db,"SELECT * FROM members where id='".$comment['user_id']."'");

                   $userName=mysqli_fetch_array($userNameSQL);

                if(isset($userPic['pic']) and $userPic['pic']!=''){
                   $img='<img src="uploads/'.$userPic['pic'].'" width="150px" height="150px" class="pic" />';
                }
                else{

                   $img='<img src="uploads/default.jpg" width="150px" height="150px" class="pic" />';
                }




       $htmlComments.='<div id="">

                        <table width="100%" >
                                 <tr>
                                    <td width="10%" >'.$img.'</td>
                                    <td width="90%" align="left" ><a href="user.php?name='.$userName['name'].'"> <h1>'.$userName['name'].' </h1></a></td>
                                  </tr>
                               <tr>
                                   <td colspan="2"><i>'.$comment['comment'].' </i></td>
                               </tr>
                               <tr align="right">
                                  <td colspan="2" >Posted on:'.$comment['date_added'].'</td>
                                </tr>
                          </table>
                      </div>';
     }

     echo  $htmlComments;

      exit;

  }

 ?>
