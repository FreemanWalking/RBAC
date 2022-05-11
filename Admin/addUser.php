<!DOCTYPE html>
<?php
require_once('config.php') ;
session_start();
if (!isset($_SESSION['E_email_admin'])){
  echo "<script>alert('Please log in first.')</script>";
  header("Location: login_admin.php");
}
?>

<head>
<title> Add User - Access Control System</title>
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
  <h1>ADD USER</h1>
  <h2><a href="logout_admin.php" style="align: left;">LOG OUT</a></h2>
  <h2><a href="menu.php" style="align: left;">BACK</a></h2>
  </div>
</div>

<form action="" method="post" class="container-fluid" id="user-add" > 
  <br>
  <div class="form-floating mb-3"> <!--additional name in the text input-->
    <input type="text" name="email" class="form-control" placeholder="Email">
    <label for="email">Email</label>
  </div>
    <div class="form-floating mb-3"><!--additional name in text input-->
    <input type="password" name="password" class="form-control" placeholder="Password">
    <label for="password">Password</label>
  </div>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <input type="text" name="name" class="form-control" placeholder="Name">
    <label for="name">Name</label>
  </div>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <input type="text" name="surname" class="form-control" placeholder="Surname">
    <label for="surname">Surname</label>
  </div>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <?php
    $sql1 = "SELECT * from Team";
    $result1 =  mysqli_query($conn, $sql1);

    echo"<select class='form-select' name='team'>";
    while($row= mysqli_fetch_array($result1)){
      echo"<option value='$row[TeamID]'>$row[Name]</option>";
    }
    echo"</select>";
    ?>
    <label for="team">Team</label>
  </div>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <?php
    $sql2 = "SELECT * from Role";
    $result2 =  mysqli_query($conn, $sql2);

    echo"<select class='form-select' name='role'>";
    while($row= mysqli_fetch_array($result2)){
      echo"<option value='$row[RoleID]'>$row[RoleName]</option>";
    }
    echo"</select>";
    ?>
    <label for="role">Role</label>
  </div>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <input type="text" name="userIP" class="form-control" placeholder="UserIP">
    <label for="userIP">UserIP</label>
  </div>
  <div class="col">
    <button id="s" type="submit" name="user-add-sub" style="width:100%;  margin-left: auto; margin-right: auto;">Create</button> 
  </div>
  <br>
</form>

<?php
if(isset($_POST['user-add-sub'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $team = $_POST['team'];
  $role = $_POST['role'];
  $userIP = $_POST['userIP'];

  echo"$email, $password,$name,$surname,$team, $role, $userIP";

  $q="call AddUser('$email', '$password', '$name', '$surname', '$team', '$role', '$userIP')";
  $result= mysqli_query($conn, $q);

  if(!$result){
    echo "Add failed. Error: ".$mysqli->error ;
    return false;
  }
  header("Location: menu.php");	
}
?>

</body>

</html>