<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $fname = mysqli_real_escape_string($conn, $_POST['fname']);
   $lname = mysqli_real_escape_string($conn, $_POST['lname']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];
   $company = $_POST['company'];
   $phone = $_POST['phone'];
   $select = " SELECT * FROM users WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exists!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_req (fname, lname, email, company, password, phn_no, user_type) VALUES ('$fname', '$lname', '$email', '$company', '$pass', '$phone','$user_type');";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style1.css">

   <style>
  label {
    display: inline-block;
    width: 150px;
  }
</style>

</head>
<body>
   
<div class="form-container">
   <br>
   <form action="" method="post">
      <h3>register now</h3>
      <br>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      
  <label for="fname">First Name:</label>
  <input type="text" id="fname" name="fname" required>

  <label for="lname">Last Name:</label>
  <input type="text" id="lname" name="lname" required>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required>

  <label for="company">Company:</label>
  <input type="text" id="company" name="company" required>

  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required>

  <label for="cpassword">Confirm Password:</label>
  <input type="password" id="cpassword" name="cpassword" required>

  <label for="phone">Phone Number:</label>
  <input type="tel" id="phone" name="phone" required>

  <label for="user_type">User Type:</label>
  <select name="user_type" >   
    <option value="user">User</option>
    <option value="admin">Admin</option>
  </select>
 <br>
 <br>
  <input type="submit" value="Register" class="form-btn" name='submit'>
      
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>

</div>

</body>
</html>