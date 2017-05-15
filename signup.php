<?php
     include('header.php');
     include("includes/config.php");

     $error='';
     $success='';


     if(isset($_POST['registerBtn'])){
        $error='';

        $name=$_POST['name'];
        $email=$_POST['email'];
        $pass=$_POST['password'];

         if(empty($name) or empty($email) or empty($pass) ){
              $error.='Please Fill Out All The Fields';
          }
          else {
             $select=mysqli_query($db,"SELECT * FroM members where email='$email' ");

               if(mysqli_num_rows($select)==0 ){

                   $token=md5($name);

                  $query="INSERT INTO members SET
                       id='',
                       name='$name',
                       email='$email',
                       password='$pass',
                       token='$token',
                       activated='1',
                       date_added = NOW()
                       ";

                      //  $to=$email;
                      //  $subject="Varification Email";
                      //  $message="Pleas Click the url in order to activate your account";
                      //  $message.="<a href='http://localhost/SocialNetworkPHP/activate?token=".$token."'>Click Here</a>";
                      //
                      // $headers="From: mahfuzcuetjava@gmail.com \n";
                      // $headers.="MIME-Version:1.0\n";
                      // $headers.="Content-type:text/html;charset=iso-8859-1\n";
                      //
                      // mail($to,$subject,$message,$headers);

                      if(mysqli_query($db,$query)){
                         $success="You Have Successfully Registered!";

                           $name='';
                           $email='';
                           $pass='';
                         }
                       else {
                         $error.="Can't Save Error I query ";
                         }
             }
             else{
                $error.='Please SignUp With Another Email????';
              }


         }

     }


?>

    <fieldset class="regFieldSet"><legend>SignUp form here</legend>

         <?php echo   $error; ?>
         <?php  echo  $success;?>
      <form method="post" action="" id="">

            <table width="100%" cellpadding="0" cellspaing="0">
                   <tr>
                      <td width="30%">Name</td>
                      <td width="70%">
                          <input type="text" name="name" class="fields" value="<?=((isset($name))?$name:'')?>"  />
                      </td>
                   </tr>
                   <tr>
                      <td width="30%">Email</td>
                      <td width="70%">
                          <input type="email" name="email" class="fields" value="<?=((isset($email))?$email:'')?>" />
                      </td>
                   </tr>
                   <tr>
                      <td width="30%">Password</td>
                      <td width="70%">
                          <input type="password" name="password" class="fields" value="<?=((isset($pass))?$pass:null)?>"/>
                      </td>
                   </tr>
                   <tr>
                      <td colspan="2">
                          <input type="submit" value="SignUp" name="registerBtn" class="btn" />
                      </td>
                   </tr>
            </table>
      </form>
    </fieldset>

<?php include('footer.php');?>
