<?php
include ( "./inc/header.inc.php" );
if($username)
{

}
else
{
    die("You must be logged in you view this page");
}
  ?>
<?php
  $senddata = @$_POST['change_password'];
  $old_password=md5(strip_tags(@$_POST['oldpassword']));
  $new_password=strip_tags(@$_POST['newpassword']);
  $repeat_password=strip_tags(@$_POST['newpassword2']);
  if($senddata)
  {
    $password_query= mysqli_query($db, "SELECT * FROM users WHERE username='$username'");
    while ($row= mysqli_fetch_assoc($password_query))
    {
      $db_password= $row['password'];
      if($old_password==$db_password)
      {
        if(strlen($new_password)>30||strlen($new_password)<5)
        {
          echo "Your new password must be between 5 and 30 characters long";
        }
        else
        {
          if($new_password==$repeat_password)
          {
            $new_password=md5($new_password);
            $repeat_password=md5($repeat_password);
            $new_password_query=mysqli_query($db,"UPDATE users SET password='$new_password' WHERE username='$username'");
            echo "Password updated";
          }
          else
          {
              echo "The new passwords doesn't matchs";
          }
        }
      }
      else
      {
        echo "The password doesn't match";
      }
    }
  }
  else
  {
    echo  "";
  }
?>

<h2 >Edit you account settings</h2><hr />
<!-- Trigger/Open The Modal -->
<form action="account_settings.php" method="POST">

  <div class="toggle"><h4>Change your password</h4></div>
  <div class="inside">
    Your Old Password:  <input type="password" name="oldpassword" id="oldpassword" size="40" placeholder="Enter your old password here"><br /><br />
    Your New Password: <input type="password" name="newpassword" id="newpassword" size="40" placeholder="Enter your new password here"><br /><br />
    Retype Your Password: <input type="password" name="newpassword2" id="newpassword2" size="40" placeholder="Retype your password here"><br /><br />
    <input type="submit" name="change_password" id="change_password" value="Update Password"><br /><br />
  </div>

</form>

<?php
$get_info=mysqli_query($db,"SELECT first_name, last_name, bio FROM users WHERE username='$username'");
$get_row=mysqli_fetch_assoc($get_info);
$i_firstname=$get_row['first_name'];
$i_lastname=$get_row['last_name'];
$i_bio=$get_row['bio'];
$user_info= @$_POST['user_info'];

if($user_info)
{
  $firstname=strip_tags(@$_POST['fname']);
  $lastname=strip_tags(@$_POST['lname']);
  $bio=strip_tags(@$_POST['aboutyou']);
  if(strlen($firstname) <3 )
  {
    echo "Your first name must be greater than 3 characters";
  }
  else
  {
    if(strlen($lastname) <4 )
    {
      echo "Your last name must be greater than 3 characters";
    }
    else
    {
        $info_query= mysqli_query($db, "UPDATE users SET first_name='$firstname' WHERE username='$username'");
        $info_query= mysqli_query($db, "UPDATE users SET last_name='$lastname' WHERE username='$username'");
        $info_query= mysqli_query($db, "UPDATE users SET bio='$bio' WHERE username='$username'");
        echo "Information updated successfully";
    }
  }
}
else
{
  echo "";
}
 ?>
<form action="account_settings.php" method="POST">

  <div class="toggle2"><h4>Update your profile info</h4></div>
  <div class="inside2">
    First Name:  <input type="text" name="fname" id="fname" size="40" value="<?php echo $i_firstname; ?>"><br /><br />
    Last Name: <input type="text" name="lname" id="lname" size="40" value="<?php echo $i_lastname; ?>"><br /><br />
    About You: <textarea name="aboutyou" id="aboutyou" rows="7" cols="60"><?php echo $i_bio; ?></textarea><br /><br />
    <input type="submit" name="user_info" id="user_info" value="Update Information"><br /><br />
  </div>

</form>
<script
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous"></script>

    <script src="js/account_settings.js"></script>