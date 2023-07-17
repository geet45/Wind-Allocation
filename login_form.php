<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['fname']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM users WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['fname'];
         header('location:admin_page.php');

      }
      elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['fname'];
         $_SESSION['email'] = $row['email'];
         $_SESSION['company'] = $row['company'];
         header('location:user_page.php');     
      }
     
   }else{
      $error[] = 'incorrect email or password!';
   }

};
?>

<DOCTYPE html>
   <head>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css"> 

</head>
<body class="login">
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>Don't have an account ? <a href="register_form.php">Register now</a></p>
   </form>

</div>

</body>
</html>