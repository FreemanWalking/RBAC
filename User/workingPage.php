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
  <title> Working Page - Access Control System</title>
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
  <h1>Working Page</h1>

  <?php

    $E_email_user = $_SESSION['E_email_user'];
    $sql = "SELECT * FROM user WHERE Email='$E_email_user'";
    $result = mysqli_query($conn, $sql);
    $userName = mysqli_fetch_array($result);

    $sql_1 = "SELECT * FROM user_role WHERE UserID='$userName[UserID]'";
    $result_1 = mysqli_query($conn, $sql_1);
    $roleId = mysqli_fetch_array($result_1);

    $sql_2 = "SELECT * FROM role WHERE RoleID='$roleId[RoleID]'";
    $result_2 = mysqli_query($conn, $sql_2);
    $roleNameId = mysqli_fetch_array($result_2);

    echo "<div style = 'font-size: 20px;'>$userName[Name] $userName[Surname], $roleNameId[RoleName]</div>"

  ?>
  <h2><a href="change_password.php" style="align: left;">Change Password</a></h2>
  <h2><a href="logout_user.php" style="align: left;">LOG OUT</a></h2>

  </div>
</div>

<form action="" method="post" class="container-fluid" id="C_password"> 


    <div class="container">
    <div class="row">

        <div class="col-2" style="background-color:rgba(0, 0, 0, 0.12);">

          <h1>Folders</h1>
          <p><b>---------------------</b></p>
          
          <div><!-- the start of lift col -->

          <!-- The start of 1st folder -->
          <p><b>Folder 1</b></p>

          <form action="" method="post"> 
            <div class="form-floating mb-3" >
              <?php
              $sql1 = "SELECT FileID  from coding WHERE ResourceID = 'Folder1'";
              $result1 =  mysqli_query($conn, $sql1);

              echo"<select class='form-select' name='File_ID' >";
              while($row= mysqli_fetch_array($result1)){
                echo "<option value='$row[FileID]' ";
                        echo "> $row[FileID] </option>";
              }
              echo"</select>";
              ?>
              <label for="File_ID">Folder1</label>
            </div>
            <input type='hidden' name='openFolder2' value= ''>
            <input type='hidden' name='File_ID_2' value=''>
            <input type='hidden' name='result_folder2' value=''>

            <!-- ******** -->
            <?php
              if ($_SESSION['folder1_read'] == 1 ){
                echo "<div style='float:left;'><button type='submit' name='openFolder1' style='width: 100%; font-size: 1.5vw; ' >Open</button></div>";
              } else{
                echo "<div style='float:left;'><button type='submit' name='openFolder1' style='width: 100%; font-size: 1.5vw; ' DISABLED>Open</button></div>";
              }
            ?>


            <?php
            
            if ($_SESSION['folder1_execute'] == 1 ){
              echo "<div style='float:right; text-align: center;'><button type='submit' name='executeFolder1' style='font-size: 1.5vw; width:100%;  margin-left: auto; margin-right: auto;' formaction = '/B/User/execute.php'>Execute</button></div>";
            } else{
              echo "<div style='float:right; text-align: center;'><button type='submit' name='executeFolder1' style='font-size: 1.5vw; width:100%;  margin-left: auto; margin-right: auto;'><a href='#'>Execute</a></button></div>";
            }
            
            ?>
            <br>


            <br>
            
            <div class="form-floating mb-3"> 
            <input type="text" name="createFile1" class="form-control" placeholder="Insert file name">
            <label for="createFile1">Insert file name</label>
            </div>
            
            <?php

              if ($_SESSION['folder1_create'] == 1 ){
                echo "<div style='float:left;'><button type='submit' name='create1' style='width: 100%; font-size: 1.5vw; ' >Create</button></div>";
                
              } else{
                echo "<div style='float:left;'><button type='submit' name='create1' style='width: 100%; font-size: 1.5vw; ' DISABLED>Create</button></div>";
      
              }

            ?>
            

            <br>
            <br>

            <div class="form-floating mb-3" >
              <?php
              $sql1 = "SELECT FileID  from coding WHERE ResourceID = 'Folder1'";
              $result1 =  mysqli_query($conn, $sql1);

              echo"<select class='form-select' name='D_File_ID'>";
              while($row= mysqli_fetch_array($result1)){
                echo "<option value='$row[FileID]' ";
                        echo "> $row[FileID] </option>";
              }
              echo"</select>";
              ?>
              <label for="D_File_ID">Folder1</label>
            </div>

            <?php

              if ($_SESSION['folder1_delete'] == 1 ){
                
                echo "<div style='float:left;'><button type='submit' name='deleteFile1' style='width: 100%; font-size: 1.5vw; ' >Delete</button></div>";
              } else{
                
                echo "<div style='float:left;'><button type='submit' name='deleteFile1' style='width: 100%; font-size: 1.5vw; ' DISABLED>Delete</button></div>";
              }

            ?>

            <br>
          </form>

          <?php
            if(isset($_POST['openFolder1'])) {
            $FileF_ID = $_POST['File_ID'];
            $q = "SELECT Code, FileID, ResourceID from coding WHERE ResourceID= 'Folder1' AND FileID = '$FileF_ID' ";
            $result_folder1= mysqli_query($conn, $q);
            if(!$result_folder1){
              echo "Selection failed. Error: " ;
            } else {
              $codeFolder1 = mysqli_fetch_array($result_folder1);
            }
            }
          ?>

          <?php
            if(isset($_POST['create1'])) {
            $createFile_1 = $_POST['createFile1'];
            $q = "INSERT INTO coding (ResourceID, FileID, Code) VALUES ('Folder1', '$createFile_1', 'Code Here')";
            $result_folder1= mysqli_query($conn, $q);
            $FileF_ID = $createFile_1;
            $q = "SELECT Code, FileID, ResourceID from coding WHERE ResourceID= 'Folder1' AND FileID = '$FileF_ID' ";
            $result_folder1= mysqli_query($conn, $q);
            if(!$result_folder1){
              echo "Selection failed. Error: " ;
            }
            if(!$result_folder1){
              echo "Selection failed. Error: " ;
            } else {
              $codeFolder1 = mysqli_fetch_array($result_folder1);
            }
            }
          ?>

          <?php
            if(isset($_POST['deleteFile1'])) {
            $D_FileF_ID = $_POST['D_File_ID'];
            $q = "DELETE FROM coding WHERE ResourceID = 'Folder1' AND FileID = '$D_FileF_ID'";
            $result_folder1= mysqli_query($conn, $q);
            if(!$result_folder1){
              echo "Selection failed. Error: " ;
            }
            }
          ?>
          <br>
          <p><b>---------------------</b></p>
          <!-- The end of 1st folder -->

          <!-- The start of 2nd folder -->
          <p><b>Folder 2</b></p>
          <form action="" method="post"> 
            <div class="form-floating mb-3" >
              <?php
              $sql2 = "SELECT FileID  from coding WHERE ResourceID = 'Folder2'";
              $result2 =  mysqli_query($conn, $sql2);

              echo"<select class='form-select' name='File_ID_2'>";
              while($row= mysqli_fetch_array($result2)){
                echo "<option value='$row[FileID]' ";
                        echo "> $row[FileID] </option>";
              }
              echo"</select>";
              ?>
              <label for="File_ID_2">Folder2</label>
            </div>
            <input type='hidden' name='openFolder1' value=''>
            <input type='hidden' name='File_ID' value=''>
            <input type='hidden' name='result_folder1' value=''>

            <!-- ******** -->

            <?php

              if ($_SESSION['folder2_read'] == 1 ){
                echo "<div style='float:left;'><button type='submit' name='openFolder2' style='width: 100%; font-size: 1.5vw; ' >Open</button></div>";
              } else{
                echo "<div style='float:left;'><button type='submit' name='openFolder2' style='width: 100%; font-size: 1.5vw; ' DISABLED>Open</button></div>";
              }

            ?>
            
            <?php
            
            if ($_SESSION['folder2_execute'] == 1 ){
              echo "<div style='float:right; text-align: center;'><button type='submit' name='executeFolder2' style='font-size: 1.5vw; width:100%;  margin-left: auto; margin-right: auto;' formaction = '/B/User/execute.php'>Execute</button></div>";
            } else{
              echo "<div style='float:right; text-align: center;'><button type='submit' name='executeFolder2' style='font-size: 1.5vw; width:100%;  margin-left: auto; margin-right: auto;'><a href='#'>Execute</a></button></div>";
            }
            
            ?>

            <br>


            <br>

            <div class="form-floating mb-3"> 
            <input type="text" name="createFile2" class="form-control" placeholder="Insert file name">
            <label for="createFile2">Insert file name</label>
            </div>

            <?php

              if ($_SESSION['folder2_create'] == 1 ){
                echo "<div style='float:left;'><button type='submit' name='create2' style='width: 100%; font-size: 1.5vw; ' >Create</button></div>";
                
              } else{
                echo "<div style='float:left;'><button type='submit' name='create2' style='width: 100%; font-size: 1.5vw; ' DISABLED>Create</button></div>";
      
              }

            ?>

            <br>
            <br>
            
            <div class="form-floating mb-3" >
              <?php
              $sql2 = "SELECT FileID  from coding WHERE ResourceID = 'Folder2'";
              $result2 =  mysqli_query($conn, $sql2);

              echo"<select class='form-select' name='D_File_ID_2'>";
              while($row= mysqli_fetch_array($result2)){
                echo "<option value='$row[FileID]' ";
                        echo "> $row[FileID] </option>";
              }
              echo"</select>";
              ?>
              <label for="D_File_ID_2">Folder2</label>
            </div>

            <?php

              if ($_SESSION['folder2_delete'] == 1 ){
                
                echo "<div style='float:left;'><button type='submit' name='deleteFile2' style='width: 100%; font-size: 1.5vw; ' >Delete</button></div>";
              } else{
                
                echo "<div style='float:left;'><button type='submit' name='deleteFile2' style='width: 100%; font-size: 1.5vw; ' DISABLED>Delete</button></div>";
              }

            ?>

            <br>
          </form>

          <?php
            if(isset($_POST['openFolder2'])) {
            $FileF_ID_2 = $_POST['File_ID_2'];
            $q = "SELECT Code, FileID, ResourceID from coding WHERE ResourceID= 'Folder2' AND FileID = '$FileF_ID_2' ";
            $result_folder2= mysqli_query($conn, $q);
            if(!$result_folder2){
              echo "Selection failed. Error: " ;
            } else {
              $codeFolder2 = mysqli_fetch_array($result_folder2);
            }
            }
          ?>

          <?php
            if(isset($_POST['create2'])) {
            $createFile_2 = $_POST['createFile2'];
            $q = "INSERT INTO coding (ResourceID, FileID, Code) VALUES ('Folder2', '$createFile_2', 'Code Here')";
            $result_folder2= mysqli_query($conn, $q);
            $FileF_ID_2 = $createFile_2;
            $q = "SELECT Code, FileID, ResourceID from coding WHERE ResourceID= 'Folder2' AND FileID = '$FileF_ID_2' ";
            $result_folder2= mysqli_query($conn, $q);
            if(!$result_folder2){
              echo "Selection failed. Error: " ;
            }
            if(!$result_folder2){
              echo "Selection failed. Error: " ;
            } else {
              $codeFolder2 = mysqli_fetch_array($result_folder2);
            }
            }
          ?>

          <?php
            if(isset($_POST['deleteFile2'])) {
            $D_FileF_ID_2 = $_POST['D_File_ID_2'];
            $q = "DELETE FROM coding WHERE ResourceID = 'Folder2' AND FileID = '$D_FileF_ID_2'";
            $result_folder2= mysqli_query($conn, $q);
            if(!$result_folder2){
              echo "Selection failed. Error: " ;
            }
            }
          ?>
          <br>
          <!-- The end of 2nd folder -->

          </div><!-- the end of left col -->
          
        


        </div>
        


        <div class="col-10">
        
          <form action="" method="post" id = "usrform">
                  <?php
                    if (isset($codeFolder1[2])){
                      print "Current folder: " . $codeFolder1[2] . "<br>";
                      print "Current file: " . $codeFolder1[1] . "<br>";
                    }
                    if (isset($codeFolder2[2])){
                      print "Current folder: " . $codeFolder2[2] . "<br>";
                      print "Current file: " . $codeFolder2[1] . "<br>";
                    }
                  ?>

                  <?php
                    if (isset($codeFolder1[0])){
                      if ($codeFolder1 != NULL){
                        $value = $codeFolder1[0];
                      }
                      echo "<input type='hidden' name='folderName' value='$codeFolder1[2]'>";
                      echo "<input type='hidden' name='fileName' value='$codeFolder1[1]'>";
                    }
                    if (isset($codeFolder2[0])){
                      if ($codeFolder2 != NULL){
                        $value = $codeFolder2[0];
                      }
                      echo "<input type='hidden' name='folderName' value='$codeFolder2[2]'>";
                      echo "<input type='hidden' name='fileName' value='$codeFolder2[1]'>";
                    }       
                  ?>
                  

                  <?php

                  if (($_SESSION['folder1_write'] == 1) && (isset($codeFolder1[2])) ){
                
                    echo "<textarea class='form-control' name = 'coding0' rows='15' form='usrform'>";
                          if (isset($value)){
                            echo "$value";
                          }
                    echo "</textarea>";
                    echo "<label class='form-label' for='coding0'></label>";
                  } elseif (($_SESSION['folder2_write'] == 1) && (isset($codeFolder2[2]))){

                    echo "<textarea class='form-control' name = 'coding0' rows='15' form='usrform'>";
                          if (isset($value)){
                            echo "$value";
                          }
                    echo "</textarea>";
                    echo "<label class='form-label' for='coding0'></label>";
                  } else{

                    echo "<textarea class='form-control' name = 'coding0' rows='15' form='usrform' DISABLED>";
                    if (isset($value)){
                            echo "$value";
                    }
                    echo "</textarea>";
                    echo "<label class='form-label' for='coding0'></label>";;
                  }

                  ?>
              

              <?php

              if (($_SESSION['folder1_write'] == 1) && (isset($codeFolder1[2])) ){
                
                echo "<div style='float:center; text-align: center;'><button type='submit' name='save' style='width: 20%; font-size: 1.5vw;'>Save</button></div>";
              } elseif (($_SESSION['folder2_write'] == 1) && (isset($codeFolder2[2]))){

                echo "<div style='float:center; text-align: center;'><button type='submit' name='save' style='width: 20%; font-size: 1.5vw;'>Save</button></div>";
              } else{

                echo "<div style='float:center; text-align: center;'><button type='submit' name='save' style='width: 20%; font-size: 1.5vw;' DISABLED>Save</button></div>";
              }

              ?>

              <br>
                 

          </form>

          <?php

            if(isset($_POST['save'])){
              if (isset($_POST['folderName'])){
              $codeFolder = $_POST['folderName'];
              $codeFile = $_POST['fileName'];
              
              $S_Folder_1 = $_POST['coding0'];
              $q = "UPDATE coding SET Code = '$S_Folder_1' WHERE ResourceID = '$codeFolder' AND FileID = '$codeFile' ";
              $result_S_folder2= mysqli_query($conn, $q);
              if(!$result_S_folder2){
                echo "Selection failed. Error: " ;
              } else {
                echo "<script>alert('You have saved.')</script>";
              }
              }     
            }

          ?>
        


        </div>
          
      
    
    </div>
    </div>
</form>



</body>
</html>