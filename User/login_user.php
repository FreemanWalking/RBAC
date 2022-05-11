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
  <h1>USER LOG IN</h1>
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
<input type="text" name="E_email_user" class="form-control" id="E_email_user" placeholder="E-mail">
<label for="E_email_user">E-mail</label>
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
  $E_email_user = $_POST['E_email_user'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM user WHERE Email='$E_email_user' AND Password='$password'";/// Email and Password --> E, P got to be capitalized following the database.
  $result = mysqli_query($conn, $sql);
  
  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['E_email_user'] = $row['Email'];
    $_SESSION['loggedin_time'] = time();

    $real_UserID = $row['UserID'];
    $sql2 = "SELECT * FROM user_role WHERE UserID= '$real_UserID' ";
    $result2 = mysqli_query($conn, $sql2);
    if ($result2->num_rows > 0) {
      $row2 = mysqli_fetch_assoc($result2);
      $Real_RoleID_user = $row2['RoleID'];
    }


    $sql3 = "SELECT * FROM permission_role WHERE RoleID='$Real_RoleID_user' AND  resource_R = 'folder1' ";
    $result3 = mysqli_query($conn, $sql3);
    if ($result3->num_rows > 0) {
      $row3 = mysqli_fetch_assoc($result3);
      $_SESSION['folder1_read'] = $row3['read_R'];
      $_SESSION['folder1_write'] = $row3['write_W'];
      $_SESSION['folder1_execute'] = $row3['execute_E'];
      $_SESSION['folder1_delete'] = $row3['delete_D'];
      $_SESSION['folder1_create'] = $row3['create_C'];
    }

    $sql4 = "SELECT * FROM permission_role WHERE RoleID='$Real_RoleID_user' AND  resource_R = 'folder2' ";
    $result4 = mysqli_query($conn, $sql4);
    if ($result4->num_rows > 0) {
      $row4 = mysqli_fetch_assoc($result4);
      $_SESSION['folder2_read'] = $row4['read_R'];
      $_SESSION['folder2_write'] = $row4['write_W'];
      $_SESSION['folder2_execute'] = $row4['execute_E'];
      $_SESSION['folder2_delete'] = $row4['delete_D'];
      $_SESSION['folder2_create'] = $row4['create_C'];
    }

    header("Location: workingPage.php");
  } else {
    echo "<script>alert('Woops! E-mail or Password is Wrong.')</script>";
  }
}
?>


</body>
</html>