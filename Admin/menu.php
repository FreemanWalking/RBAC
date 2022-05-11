<!DOCTYPE html>
<?php
require_once('config.php') ;
session_start();
if (!isset($_SESSION['E_email_admin'])){
  header("Location: login_admin.php");
}
?>
<!--Await for bug squashing-->
<head>
  <title> Menu - Access Control System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Include Bootstrap 5 from a CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<div class="container-fluid" id="header">
  <h1>MENU</h1>
  <h2><a href="logout_admin.php" style="align: left;">LOG OUT</a></h2>
</div>
<div class="container-fluid" id="menu">
  <div class="row" style="height: 5vw;">
    <div class="col-5"><a href="addUser.php"><button id="s" type="submit" name="AddUser" >Add New User</button></a></div> 
    <div class="col-2"></div>
    <div class="col-5"><a href="addRole.php"><button id="s" type="submit" name="AddRole" >Add New Role</button></a></div> 
  </div>
  <br><br><br>
  <div class="row" style="height: 5vw;">
    <div class="col-5"><a href="editUser.php"><button id="s" type="submit" name="AddUser" >Edit User</button></a></div> 
    <div class="col-2"></div>
    <div class="col-5"><a href="editRole.php"><button id="s" type="submit" name="AddRole" >Edit Role</button></a></div> 
  </div>
  <br><br><br>
  <div class="row" style="height: 5vw;">
    <div class="col-5"><a href="createTeam.php"><button id="s" type="submit" name="CreateTeam" >Create team</button></a></div> 
    <div class="col-2"></div>
    <div class="col-5"><a href="editTeam.php"><button id="s" type="submit" name="EditTeam" >Edit team</button></a></div> 
  </div>
</div>

</body>
</html>