<?php
   // Start a session to store user data
   session_start();
   include '../../connection.php';
   
   if (isset($_SESSION['username'])) {
     $username = $_SESSION['username'];
   } else {
     header("Location: ../../index.html");
     exit();
   }
   
   ?>
   <!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Ideal Results Portal</title>
  <link rel = "icon" href = "../../ideal_logo.jpg" type = "image/x-icon">
  <link rel='stylesheet' href='https://gist.githubusercontent.com/rwbaker/1291602/raw/24642dc1a083a0081f2cb2cb15a85eac0a554478/html5reset.css'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lato:300,400,700'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css'><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div id="popupLogIn">
  <aside>
    <div class="content">
      <img width="60" height="100" align="center" src="../../ideal_logo.jpg">
      <p class="title">IDEAL INSTITUTE OF TECHNOLOGY </p>
      <p class="subtitle">KAKINADA</p>
      <p class="para">You can change your password multiple times if you can remember you'r old password. contact your respective HOD to get your old passwords</p>
      <ul>
        <li>Enter your college rollnumber</li>
        <li>Enter your old password</li>
        <li>Enter your new password</li>
        <li>Re-Enter your new password</li>
      </ul>
    </div>
  </aside>
  <div class="logIn">
    <div class="forms">
      <div class="form">
        <p class="title">Change Password</p>
        <form action="change.php" method="POST">
          <p class="username"><input type="text" name="rollnumber" placeholder="Your Rollnumber" required></p>
          <p class="oldpass"><input type="password" name="old_password" placeholder="Your Old Password" required></p>
          <p class="newpass"><input type="password" name="new_password" placeholder="Your New Password" required></p>
          <p class="confirm"><input type="password" name="confirm_password" placeholder="Re-enter New Password" class="mB0" required></p>
          <div class="submit">
      <button type="submit">Submit</button>
    </div>
        </form>
        <div class="separateur"><span>Or</span></div>
      </div>
      <div class="sociaux">
        <p class="title">Also, you can...</p>
        <p style="font-weight:300;"> If you are facing issues with changing your password or need assistance in changing your password, please contact your Head of Department (HOD) for further support.</p>
      </div>
    </div>
    
  </div>
</div>
<div id="fadeGray"></div>
<!-- partial -->
  <a href="../result.php" style="position: absolute; right: 50px; top: 50px; ">
    <i class="fa fa-home fa-3x" style="color: white;"></i>
  </a>
</body>
</html>
