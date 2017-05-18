<?php
     include('header.php');
     include("includes/config.php");

      // session_start();

     $error='';
     $success='';
     $country='';
     $userId=$_SESSION['members_id'];

     $select=mysqli_query($db,"SELECT * FROM profile where user_id='$userId'");


     if(mysqli_num_rows($select)==1){

       $result=mysqli_fetch_array($select);

       $about=$result['about'];
       $gender=$result['gender'];
       $education1=$result['edu1'];
       $education2=$result['edu2'];
       $education3=$result['edu3'];
       $dob=$result['dob'];
       $country=$result['country'];
       $pic=$result['pic'];



                   if(isset($_POST['saveBtn'])){
                      $error='';

                        $about=$_POST['about'];
                        $gender=$_POST['gender'];
                        $education1=$_POST['education1'];
                        $education2=$_POST['education2'];
                        $education3=$_POST['education3'];
                        $dob=$_POST['dob'];
                        $country=$_POST['country'];




                          if(!empty($about) and !empty($gender) and !empty($education1) and !empty($education2) and !empty($education3) and !empty($dob) and  !empty($country)){

                                     //var_dump($_FILES);
                                  $fileName=$_FILES['ppicture']['name'];
                                  $tempName= $_FILES['ppicture']['tmp_name'];
                                  $fileName=rand(9999,10000).date('Ymdhis').$fileName;
                                  move_uploaded_file($tempName,'uploads/'.$fileName);
                                   if($tempName==null){

                                       $insert="UPDATE profile set  about='$about', gender='$gender', dob='$dob', edu1='$education1', edu2='$education2', edu3='$education3', country='$country', date_added=NOW() where user_id='$userId'";
                                       mysqli_query($db,$insert);
                                   }
                                   else {

                                      $insert="UPDATE profile set  about='$about',pic='$fileName', gender='$gender', dob='$dob', edu1='$education1', edu2='$education2', edu3='$education3', country='$country', date_added=NOW() where user_id='$userId'";
                                      mysqli_query($db,$insert);
                                   }

                                 $success.='Updated !';
                            }
                         else {
                                $error.='Can not Insert Data Error Occured!!!!!!';

                            }

                  }



     }
     else {


            if(isset($_POST['saveBtn'])){
               $error='';

                 $about=$_POST['about'];
                 $gender=$_POST['gender'];
                 $education1=$_POST['education1'];
                 $education2=$_POST['education2'];
                 $education3=$_POST['education3'];
                 $dob=$_POST['dob'];
                 $country=$_POST['country'];




                   if(!empty($about) and !empty($gender) and !empty($education1) and !empty($education2) and !empty($education3) and !empty($dob) and  !empty($country)){


                                $fileName=$_FILES['ppicture']['name'];
                                $tempName= $_FILES['ppicture']['tmp_name'];
                                $fileName=rand(9999,10000).date('Ymdhis').$fileName;
                                move_uploaded_file($tempName,'uploads/'.$fileName);

                          $insert="INSERT INTO profile set id='', pic='$fileName',about='$about', gender='$gender', dob='$dob', edu1='$education1', edu2='$education2', edu3='$education3', country='$country', date_added=NOW(), user_id='$userId'";

                         mysqli_query($db,$insert);

                         $success.='Saved !';
                     }
                  else {
                         $error.='Can not Insert Data Error Occured!!!!!!';

                     }

           }

     }




     /**************************Get Country Code*******************************/
        $options='';
          $countries=mysqli_query($db,"SELECT * FROM countries");

           while ($res=mysqli_fetch_array($countries)) {
             $options.='<option value="'.$res['id'].'"  '.(($country==$res['id'])?"selected":"").'>'.$res['country_name'].'</option>';
         }

   /**************************END of Get Country Code*******************************/
?>

    <fieldset class="regFieldSet"><legend>Welcome To My Website</legend>

         <?php echo   $error; ?>
         <?php  echo  $success;?>
      <form method="post" action="" id="" enctype="multipart/form-data">

            <table width="100%" cellpadding="0" cellspaing="0">
                   <tr>
                      <td colspan="2">
                           <img src="uploads/<?= $pic;?>" width="150px" height="150px" class="pic" />
                      </td>
                   </tr>
                   <tr>
                      <td width="30%">Profile Picture</td>
                      <td width="70%">
                          <input type="file" name="ppicture" class="fields"  />
                      </td>
                   </tr>
                   <tr>
                      <td width="30%">About</td>
                      <td width="70%">
                          <textarea  name="about" class="fields_textarea"  value="<?=((isset($about))?$about:'') ?>" ></textarea>
                      </td>
                   </tr>
                   <tr>
                      <td width="30%">Gender</td>
                      <td width="70%">
                          <input type="radio" name="gender" value="m" checked   >Male</input>
                          <input type="radio" name="gender" value="f"  >Female</input>
                      </td>
                   </tr>
                   <tr>
                      <td width="30%">Date of Birth</td>
                      <td width="70%">
                          <input type="date" name="dob" value="<?=((isset($dob))?$dob:'') ?>"   />
                      </td>
                   </tr>
                   <tr>
                      <td width="30%">Education</td>
                      <td width="70%">
                          <input type="text" name="education1"  class="fields" value="<?=((isset($education1))?$education1:'') ?>" />
                          <input type="text" name="education2"  class="fields" value="<?=((isset($education2))?$education2:'') ?>" />
                          <input type="text" name="education3"  class="fields" value="<?=((isset($education3))?$education3:'') ?>" />
                      </td>
                   </tr>
                   <tr>
                      <td width="30%">Counry</td>
                      <td width="70%">
                          <select class="fields" name="country" value="<?=((isset($country))?$country:'') ?>">
                               <?php echo $options;  ?>
                          </select>
                      </td>
                   </tr>


                   <tr>
                      <td colspan="2">
                          <input type="submit" value="Save" name="saveBtn" class="btn" />
                      </td>
                   </tr>
            </table>
      </form>
    </fieldset>

<?php include('footer.php');?>
