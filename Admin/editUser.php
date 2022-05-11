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
  <title> Edit User - Access Control System</title>
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
  <h1>EDIT USER</h1>
  <h2><a href="logout_admin.php" style="align: left;">LOG OUT</a></h2>
  <h2><a href="menu.php" style="align: left;">BACK</a></h2>
  </div>
</div>
<form action="" method="post" class="container-fluid" id="login"> 
  <br>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <?php
    $sql = "SELECT * from User";
    $result =  mysqli_query($conn, $sql);

    echo"<select name='user'>";
    echo"<option>-- User --</option>";
    while($row= mysqli_fetch_array($result)){
      echo"<option value='$row[UserID]'> $row[UserID] $row[Name] $row[Surname]</option>";
    }
    echo"</select>";
    ?>
  </div>
    <button id="s" type="submit" name="userid-sub" style="width:100%;  margin-left: auto; margin-right: auto;">Select</button> 

  <br>
</form>

<?php
if(isset($_POST['userid-sub'])) {
  $user = $_POST['user'];
	$q = "SELECT * from User JOIN User_role on User.userid = User_role.userid WHERE User.userid = '$user'";
	$result_id= mysqli_query($conn, $q);
  if(!$result_id){
    echo "Selection failed. Error: ".$mysqli->error ;
    return false;
  }
  else{
    $user_row= mysqli_fetch_array($result_id);
  }
?>

  <form action="" method="post" class="container-fluid" id="user-add" > 
    <br>
    <div class="form-floating mb-3"> <!--additional name in the text input-->
      <input type="text" name="user" class="form-control" value="<?php echo "$user";?>" readonly>
      <label for="user">UserID</label>
    </div>
    <div class="form-floating mb-3"> <!--additional name in the text input-->
      <input type="text" name="email" class="form-control" value="<?php echo "$user_row[Email]";?>" readonly>
      <label for="email">Email</label>
    <div class="form-floating mb-3" ><!--additional name in text input-->
      <input type="text" name="name" class="form-control" value="<?php echo "$user_row[Name]";?>" readonly>
      <label for="name">Name</label>
    </div>
    <div class="form-floating mb-3" ><!--additional name in text input-->
      <input type="text" name="surname" class="form-control" value="<?php echo "$user_row[Surname]";?>" readonly>
      <label for="surname">Surname</label>
    </div>
    <div class="form-floating mb-3" ><!--additional name in text input-->
      <?php
      $sql1 = "SELECT * from Team";
      $result1 =  mysqli_query($conn, $sql1);

      echo"<select class='form-select' name='team'>";
      while($row= mysqli_fetch_array($result1)){
        echo "<option value='$row[TeamID]' ";
								if ($user_row['TeamID'] == $row['TeamID'])
									echo "SELECTED";
								echo "> $row[Name] </option>";
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
        echo"<option value='$row[RoleID]' ";
        if ($user_row['RoleID'] == $row['RoleID'])
									echo "SELECTED";
        echo">$row[RoleName]</option>";
      }
      echo"</select>";
      ?>
      <label for="role">Role</label>
    </div>
    <div class="form-floating mb-3" ><!--additional name in text input-->
      <input type="text" name="userIP" class="form-control" value="<?php echo "$user_row[UserIP]";?>">
      <label for="userIP">UserIP</label>
    </div>
    <div class="col">
      <button id="s" type="submit" name="user-edit-sub" style="width:100%;  margin-left: auto; margin-right: auto;">Edit</button> 
    </div>
    <br>
  </form>
<?php
}
if(isset($_POST['user-edit-sub'])) {
  $user = $_POST['user'];;
  $team = $_POST['team'];
  $role = $_POST['role'];
  $userIP = $_POST['userIP'];
	$q="call EditUser ('$user','$userIP','$team','$role')"; 
	
	$result= mysqli_query($conn, $q);
		if(!$result){
			echo "Update failed. Error: ".$mysqli->error ;
			return false;
		}
	header("Location: menu.php");	
	}
?>
</body>
</html>