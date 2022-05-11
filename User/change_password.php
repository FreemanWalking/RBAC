<!DOCTYPE html>
<?php
require_once('config.php') ;
session_start();
if (!isset($_SESSION['E_email_user'])){
  header("Location: login_user.php");
}

if(isLoginSessionExpired($conn)) {
  header("Location: logout_user.php");
}
?>

<!--Await for bug squashing-->
<head>
  <title> Change Password - Access Control System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Include Bootstrap 5 from a CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<div class="container-fluid" id="header">
<div class="row">

  <h1>Change Password</h1>
  <h2><a href="workingPage.php" style="align: left;">BACK</a></h2>
  <h2><a href="logout_user.php" style="align: left;">LOG OUT</a></h2>

</div>
</div>

<form action="" method="post" class="container-fluid" id="C_password"> 
  <br>

  <div class="form-floating mb-3" >
      <input type="text" name="Old_Password" class="form-control">
      <label for="Old_Password">Old Password</label>
  </div>

  <div class="form-floating mb-3" >
      <input type="text" name="New_Password" class="form-control">
      <label for="New_Password">New Password</label>
  </div>

  <div class="form-floating mb-3" >
      <input type="text" name="Again_New_Password" class="form-control">
      <label for="Again_New_Password">Again New Password</label>
  </div>
  
  <div class="col">
      <button id="s" type="submit" name="change-passord" style="width:100%;  margin-left: auto; margin-right: auto;">Confirm</button> 
  </div>

  <br>
</form>

<?php
if (isset($_POST ["change-passord"])){
  $o_pass = $_POST['Old_Password'];
  $n_pass = $_POST["New_Password"];
  $a_n_pass = $_POST["Again_New_Password"];
  $e_mail_u = $_SESSION['E_email_user'];

  $original_pass = "SELECT Password FROM user WHERE Email = '$e_mail_u'";
  $result_0 = mysqli_query($conn, $original_pass);

  if ($result_0-> num_rows == 1){
    $row = $result_0 -> fetch_assoc();
    if ($row['Password'] != $o_pass){
      echo "<script>alert('Woops! Old Password is wrong .')</script>";
    } else {
      if ($n_pass == $a_n_pass){
        $sql = "UPDATE user SET Password = '$n_pass' WHERE Email = '$e_mail_u' ";
        $result = mysqli_query($conn, $sql);
        echo "<script>alert('You have changed the PASSWORD.')</script>";
        
      } else {
        echo "<script>alert('Woops! New Password or Again New Password is wrong .')</script>";
      }
    }
  }  
}
?>



</body>
</html>