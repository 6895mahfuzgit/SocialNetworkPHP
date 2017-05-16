<?php
     include('header.php');
     include("includes/config.php");

      // session_start();

     $error='';
     $success='';


     if(isset($_POST['loginBtn'])){
        $error='';


        $email=$_POST['email'];
        $pass=$_POST['password'];

         if( empty($email) or empty($pass) ){
              $error.='Please Fill Out All The Fields';
          }
          else {
             $select=mysqli_query($db,"SELECT * FroM members where email='$email'  and password='$pass' and activated='1' ");

                  if(mysqli_num_rows($select)==1 ){

                        $result=mysqli_fetch_array($select);
                        $_SESSION['members_id']=$result['id'];
                        $_SESSION['name']=$result['name'];

                          header("Location:index.php");
                   }
                 else {
                   $error.='Invalid Email and Password?? OR Validate you accout through Email';
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
                          <input type="submit" value="SignIn" name="loginBtn" class="btn" />
                      </td>
                   </tr>
            </table>
      </form>
    </fieldset>

<?php include('footer.php');?>
