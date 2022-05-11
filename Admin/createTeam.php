<!DOCTYPE html>
<?php
require_once('config.php') ;
session_start();
if (!isset($_SESSION['E_email_admin'])){
  echo "<script>alert('Please log in first.')</script>";
  header("Location: login_admin.php");
}
?>
<!--Await for bug squashing-->
<head>
  <title> Create Team - Access Control System</title>
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
  <h1>Create Team</h1>
  <h2><a href="logout_admin.php" style="align: left;">LOG OUT</a></h2>
  <h2><a href="menu.php" style="align: left;">BACK</a></h2>
  </div>
</div>

<form action="" method="post" class="container-fluid" id="C_password"> 
  <br>

  <div class="form-floating mb-3" >
      <input type="text" name="Create_Team" class="form-control">
      <label for="Create_Team">Team Name</label>
  </div>
  
  <div class="col">
      <button id="s" type="submit" name="create-team" style="width:100%;  margin-left: auto; margin-right: auto;">Create</button> 
  </div>

  <br>
</form>

<?php
if (isset($_POST ["create-team"])){
  $c_team = $_POST['Create_Team'];

    if($c_team != ''){
      $r_create_team = "INSERT INTO team (name) VALUES ('$c_team')";
      $result_0 = mysqli_query($conn, $r_create_team);
      if(!$result_0){
        echo "Update failed. Error: ".$mysqli->error ;
        return false;
        } else{
            echo "<script>alert('You have created a new team.')</script>";
        }
    } else {
      echo "<script>alert('Plese insert value.')</script>";
    }

}
?>



</body>
</html>