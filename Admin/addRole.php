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
  <title> Add Role - Access Control System</title>
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
  <h1>ADD ROLE</h1>
  <h2><a href="logout_admin.php" style="align: left;">LOG OUT</a></h2>
  <h2><a href="menu.php" style="align: left;">BACK</a></h2>
  </div>
</div>

<?php
  $name = "name";
  $allowedtime_from = "00:00";
  $allowedtime_to = "00:00";
  $parentrole = "";
  if(isset($_POST['role-add-sub'])){
    $name = $_POST['name'];
    $allowedtime_from = $_POST['allowedtime_from'];
    $allowedtime_to = $_POST['allowedtime_to'];
    $parentrole = $_POST['parentrole'];
  }
?>

<form action="" method="post" class="container-fluid" id="user-add" > 
  <br>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <input type="text" name="name" class="form-control" value = "<?php echo "$name"; ?>">
    <label for="name">Name</label>
  </div>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <input type="time" name="allowedtime_from" class="form-control" value = "<?php echo "$allowedtime_from"; ?>">
    <label for="allowedtime_from">Allowed Time From</label>
  </div>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <input type="time" name="allowedtime_to" class="form-control" value = "<?php echo "$allowedtime_to"; ?>">
    <label for="allowedtime_to">Allowed Time To</label>
  </div>  
    <div class="form-floating mb-3" >
      <?php
      $sql2 = "SELECT * from Role";
      $result2 =  mysqli_query($conn, $sql2);

      echo"<select class='form-select' name='parentrole'>";
      while($row= mysqli_fetch_array($result2)){
        if( $row['RoleID'] == $parentrole)
          echo"<option value='$row[RoleID]' SELECTED > $row[RoleName] </option>";
        else
          echo"<option value='$row[RoleID]'>$row[RoleName]</option>";
      }
      echo"</select>";
      ?>
      <label for="parentrole">Parent Role</label>
    </div>
    <div class='col'>
      <button id="s" type="submit" name="role-add-sub" >Select</button> 
    </div>
</form>
<?php
if(isset($_POST['role-add-sub'])) {
  // $name = $_POST['name'];
  // $allowedtime_from = $_POST['allowedtime_from'];
  // $allowedtime_to = $_POST['allowedtime_to'];
  // $parentrole = $_POST['parentrole'];


  $q="call AddNewRole('$name', '$allowedtime_from', '$allowedtime_to', '$parentrole')";
  $result= mysqli_query($conn, $q);
  mysqli_next_result($conn);

  if (!$result){
    echo "Add failed. Error: ".$conn->error ;
    return false;
  }

?>
    <table class="table" style="background-color: white;">
      <thead>
        <tr>  
            <th scope="col">Resource</th>
            <th scope="col">Read</th>
            <th scope="col">Write</th>
            <th scope="col">Execute</th>
            <th scope="col">Delete</th>
            <th scope="col">Create</th>
            <th scope="col">Save</th>
        </tr>
      </thead>
      <tbody>
        <?php      
            $sql1 = "SELECT * FROM permission_role WHERE RoleID = '$parentrole'";
            $result1 = mysqli_query($conn, $sql1);
            if(!$result1){
              echo "see permission failed. Error: ".$conn->error ;
              return false;
            }
            if ($result1){
              while ($row1 = $result1 -> fetch_assoc()){
                echo '<form action="/RBAC/Admin/add.php" method="post" > ';
                
                echo "<tr><td>".$row1['resource_R']. "</td>";
                if ($row1["read_R"]==1)
                  echo" <td><input type='checkbox' name='r' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='r' DISABLED> </td>";
                
                if ($row1["write_W"]==1)
                  echo "<td><input type='checkbox' name='w' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='w' DISABLED> </td>";
                
                if ($row1["execute_E"]==1)
                  echo "<td><input type='checkbox' name='e' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='e' DISABLED> </td>";
                
                if ($row1["delete_D"]==1)
                  echo "<td><input type='checkbox' name='d' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='d' DISABLED> </td>";
                
                if ($row1["create_C"]==1)
                  echo "<td><input type='checkbox' name='c' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='c' DISABLED> </td>";

                echo "<input type='hidden' name='rolename' value='".$name."'>";
                echo "<td> <button id='s' type='submit' name='perm-sub' style='font-size: 1.5vw; width:100%;  margin-left: auto; margin-right: auto;' formaction='/RBAC/Admin/add.php?entry_id=".$row1['resource_R']."' formTarget='_blank'>Save</button> ";
                echo "</form></tr>"; 
                
              }
            }$conn->close();
        ?>
      </tbody>
    </table>
    <?php
  }?>



</body>
</html>
