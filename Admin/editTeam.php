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
  <title> Edit Team - Access Control System</title>
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
  <h1>Edit Team</h1>
  <h2><a href="logout_admin.php" style="align: left;">LOG OUT</a></h2>
  <h2><a href="menu.php" style="align: left;">BACK</a></h2>
  </div>
</div>


<form action="" method="post" class="container-fluid" id="login"> 
  <br>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <?php
    $sql = "SELECT * from team";
    $result =  mysqli_query($conn, $sql);

    echo"<select name='teamID'>";
    echo"<option>-- Team ID --</option>";
    while($row= mysqli_fetch_array($result)){
      echo"<option value='$row[TeamID]'>row[Name]</option>";
    }
    echo"</select>";
    ?>

  </div>
  <div class="form-floating mb-3" >
      <input type="text" name="NewTeamName" class="form-control">
      <label for="NewTeamName">Insert new team name</label>
  </div>
    <button id="s" type="submit" name="teamId-sub" style="width:100%;  margin-left: auto; margin-right: auto;">Edit</button> 
  <br>
</form>

<?php
if (isset($_POST ["teamId-sub"])){
  $team_ID = $_POST['teamID'];
  $n_team_name = $_POST["NewTeamName"];
  if($n_team_name != ''){
    $r_edit_team_id = "UPDATE team SET Name = '$n_team_name' WHERE TeamID = $team_ID ; ";
    $result = mysqli_query($conn, $r_edit_team_id);
    if(!$result){
      echo "Update failed. Error: ".$mysqli->error ;
      return false;
      } else{
          header("Refresh:0");
          echo "<script>alert('You have edited the team name.')</script>";
      }
  } else {
    echo "<script>alert('Plese insert value.')</script>";
  }


  
  
}
?>

</body>
</html>