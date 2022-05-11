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
  <title> Edit Role - Access Control System</title>
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
  <h1>EDIT ROLE</h1>
  <h2><a href="logout_admin.php" style="align: left;">LOG OUT</a></h2>
  <h2><a href="menu.php" style="align: left;">BACK</a></h2>
  </div>
</div>

<form action="" method="post" class="container-fluid" id="login"> 
  <br>
  <div class="form-floating mb-3" ><!--additional name in text input-->
    <?php
    $sql = "SELECT * from role";
    $result =  mysqli_query($conn, $sql);

    echo"<select name='R_role'>";
    echo"<option>-- Role ID --</option>";
    while($row= mysqli_fetch_array($result)){
      echo"<option value='$row[RoleID]'> $row[RoleName] </option>";
    }
    echo"</select>";
    ?>
  </div>
    <button id="s" type="submit" name="roleid-sub" style="width:100%;  margin-left: auto; margin-right: auto;">Select</button> 
</form> 
<?php
  if(isset($_POST['roleid-sub'])) {
    $Role_ID = $_POST['R_role'];
?>
    <div class="container-fluid">
    <table class="table" style="background-color: white;">
      <thead> 
          <tr>  
            <th scope="col">Resource</th>
            <th scope="col">Read</th>
            <th scope="col">Write</th>
            <th scope="col">Execute</th>
            <th scope="col">Delete</th>
            <th scope="col">Create</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $q1 = "SELECT resource_R, read_R, write_W, execute_E, delete_D, create_C from permission_role WHERE RoleID = '$Role_ID' ORDER BY resource_R";
          $result1 = $conn-> query($q1, MYSQLI_STORE_RESULT);
          
          if ($result1-> num_rows > 0){ //permission_role found
            $rolearr = array(
              array("r" => 0, "w" => 0, "e" => 0, "d" => 0, "c" => 0, "res" => "0"),
              array("r" => 0, "w" => 0, "e" => 0, "d" => 0, "c" => 0, "res" => "0")
            );
            $i=0;
            while ($row = $result1 -> fetch_assoc()){
              $rolearr[$i]["r"] = $row["read_R"];
              $rolearr[$i]["w"] = $row["write_W"];
              $rolearr[$i]["e"] = $row["execute_E"];
              $rolearr[$i]["d"] = $row["delete_D"];
              $rolearr[$i]["c"] = $row["create_C"];
              $rolearr[$i]["res"] = $row['resource_R'];
              $i++;
            }
            $q2 = "SELECT ParentID FROM parent_child WHERE ChildID = '$Role_ID'";
            $result2 = $conn-> query($q2, MYSQLI_STORE_RESULT);
            if ($result2-> num_rows > 0){ //Have parent->not default role
              //echo "not default\n";
              $row2 = $result2 -> fetch_assoc();
              $parentID = $row2['ParentID'];
              $q3 = "SELECT resource_R, read_R, write_W, execute_E, delete_D, create_C from permission_role WHERE RoleID = '$parentID' ORDER BY resource_R";
              $result3 = $conn-> query($q3);
              $i=0;
              while ($parent = $result3 -> fetch_assoc()){
                echo '<form action="/RBAC/Admin/add.php" method="post" > ';
                //echo "i this round: ".$i;
                echo "<tr><td>".$rolearr[$i]["res"]. "</td>";
                if ($rolearr[$i]["r"]==1)
                  echo" <td><input type='checkbox' name='r' checked> </td>";
                else if ($parent["read_R"]==0)
                  echo "<td><input type='checkbox' name='r' DISABLED> </td>";
                else
                  echo "<td><input type='checkbox' name='r' > </td>";
                
                if ($rolearr[$i]["w"]==1)
                  echo "<td><input type='checkbox' name='w' checked> </td>";
                else if ($parent["write_W"]==0)
                  echo "<td><input type='checkbox' name='w' DISABLED> </td>";
                else
                  echo "<td><input type='checkbox' name='w'> </td>";
                
                if ($rolearr[$i]["e"]==1)
                  echo "<td><input type='checkbox' name='e' checked> </td>";
                else if ($parent["execute_E"]==0)
                  echo "<td><input type='checkbox' name='e' DISABLED> </td>";
                else
                  echo "<td><input type='checkbox' name='e'> </td>";
                
                if ($rolearr[$i]["d"]==1)
                  echo "<td><input type='checkbox' name='d' checked> </td>";
                else if ($parent["delete_D"]==0)
                  echo "<td><input type='checkbox' name='d' DISABLED> </td>";
                else
                  echo "<td><input type='checkbox' name='d'> </td>";
                
                if ($rolearr[$i]["c"]==1)
                  echo "<td><input type='checkbox' name='c' checked> </td>";
                else if ($parent["create_C"]==0)
                    echo "<td><input type='checkbox' name='c' DISABLED> </td>";
                else
                  echo "<td><input type='checkbox' name='c'> </td>";

                echo "<input type='hidden' name='roleID' value='".$Role_ID."'>";
                echo "<td> <button id='s' type='submit' name='perm-sub' style='font-size: 1.5vw; width:100%;  margin-left: auto; margin-right: auto;' formaction='/RBAC/Admin/edit.php?entry_id=".$rolearr[$i]["res"]."' formTarget='_blank'>Save</button> ";
                echo "</form></tr>"; 
                $i++;
              }
              
            }
            else{ //Default role
              mysqli_next_result($conn);
              //echo "default\n";
              for($i=0; $i<2; $i++){
                echo '<form action="/RBAC/Admin/add.php" method="post" > ';
                //echo "i this round: ".$i;
                echo "<tr><td>".$rolearr[$i]["res"]."</td>";
                if ($rolearr[$i]["r"]==1)
                  echo" <td><input type='checkbox' name='r' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='r' DISABLED> </td>";
                
                if ($rolearr[$i]["w"]==1)
                  echo "<td><input type='checkbox' name='w' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='w' DISABLED> </td>";
                
                if ($rolearr[$i]["e"]==1)
                  echo "<td><input type='checkbox' name='e' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='e' DISABLED> </td>";
                
                if ($rolearr[$i]["d"]==1)
                  echo "<td><input type='checkbox' name='d' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='d' DISABLED> </td>";
                
                if ($rolearr[$i]["c"]==1)
                  echo "<td><input type='checkbox' name='c' checked> </td>";
                else
                  echo "<td><input type='checkbox' name='c' DISABLED> </td>";
                echo "<input type='hidden' name='roleID' value='".$Role_ID."'>";
                echo "<td> <button id='s' type='submit' name='perm-sub' style='font-size: 1.5vw; width:100%;  margin-left: auto; margin-right: auto;' formaction='/RBAC/Admin/edit.php?entry_id=".$rolearr[$i]["res"]."' formTarget='_blank'>Save</button> ";
                echo "</form></tr>"; 
                
              }
            }
            
            
          }
        ?> 

      </tbody>
    </table>
    </div>

    <?php
      $qL = "SELECT * from role WHERE RoleID = '$Role_ID'";
      $resultL = $conn-> query($qL);
      $rowL= mysqli_fetch_array($resultL);
      
      if(isset($rowL['Allowed_time'])){
        $allowedtime_from = $rowL['Allowed_time'];
      }
      if(isset($rowL['Allowed_time_end'])){
        $allowedtime_to = $rowL['Allowed_time_end'];
      }
      
    ?>
    <form action="" method="post" class="container-fluid" id="user-add" >
    <div class="form-floating mb-3" ><!--additional name in text input-->
      <input type="time" name="allowedtime_from" class="form-control" value = "<?php echo "$allowedtime_from"; ?>">
      <label for="allowedtime_from">Allowed Time From</label>
    </div>

    <div class="form-floating mb-3" ><!--additional name in text input-->
      <input type="time" name="allowedtime_to" class="form-control" value = "<?php echo "$allowedtime_to"; ?>">
      <label for="allowedtime_to">Allowed Time To</label>
    </div>
    <input type='hidden' name='RoleID' value= "<?php echo "$Role_ID"; ?>">
    <div style='float:center;'><button type='submit' name='editTimeRole' style='width: 100%; font-size: 1.5vw; ' >Edit</button></div>
    <br>
    </form>

  <?php
  } ?>

    <?php
      if(isset($_POST['editTimeRole'])){

        $RoleIDSL = $_POST['RoleID'];
        $allowedtime_from_L = $_POST['allowedtime_from'];
        $allowedtime_to_L = $_POST['allowedtime_to'];
        $qSL = "UPDATE role SET Allowed_time = '$allowedtime_from_L', Allowed_time_end = '$allowedtime_to_L' WHERE RoleID = '$RoleIDSL'";
        $resultSL= mysqli_query($conn, $qSL);
      }
    ?>

</body>
</html>
