<!DOCTYPE html>
<!--Take the log in first back-->
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
  <title> Execute Page - Access Control System</title>
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
  <h1>You have executed.</h1>
  <?php
            if(isset($_POST['executeFolder1'])) {
              $FileF_ID = $_POST['File_ID'];
              $Folder = 'Folder 1';
            } elseif (isset($_POST['executeFolder2'])){
              $FileF_ID = $_POST['File_ID_2'];
              $Folder = 'Folder 2';
            }
            echo "<h1>".$Folder.', '.$FileF_ID."</h1>";
  ?>

  </div>
  
  <div class="row">
  <h2><a href="workingPage.php" style="align: left;">BACK</a></h2>
  <h2><a href="logout_user.php" style="align: left;">LOG OUT</a></h2>
  </div>

</div>

</body>
</html>