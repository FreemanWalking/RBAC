<!DOCTYPE html>
<?php
require_once('config.php') ;
session_start();
?>
<html>
<head>
<!-- Specify web page title -->
<title>Log In - Access Control System</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Include Bootstrap 5 from a CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>


</head>
<body>
<div class="container-fluid" id="header">
  <h1>ADMIN LOG IN</h1>
  <h2><a href="../index.php" style="align: left;">Back</a></h2>
</div>

<!-- Log in -->
<br><br><br>
<form action="" method="post" class="container-fluid" id="login" > 
<div class="row">
<h2 style="text-align: center; margin-top: 5%">Sign In</h2>
</div>
<br>
<div class="form-floating mb-2"> <!--additional name in the text input-->
<input type="text" name="E_email_admin" class="form-control" id="E_email_admin" placeholder="Admin E-mail">
<label for="E_email_admin">Admin E-mail</label>
</div>
<div class="form-floating mb-3"><!--additional name in text input-->
<input type="password" name="password" class="form-control" id="password" placeholder="Password">
<label for="password">Password</label>
</div>
<div class="col">
<button id="s" type="submit" name="search" style="width:100%;  margin-left: auto; margin-right: auto;">Log In</button> 
</div>
<br>
</form>
<?php
if (isset($_POST['search'])){
  $E_email_admin = $_POST['E_email_admin'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM admin WHERE Email_admin='$E_email_admin' AND Password_admin = '$password'";
  $result = mysqli_query($conn, $sql);
  
  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['E_email_admin'] = $row['Email_admin'];
    header("Location: menu.php");
  } else {
    echo "<script>alert('Woops! E-mail or Password is Wrong.')</script>";
  }
}
?>


</body>
</html>