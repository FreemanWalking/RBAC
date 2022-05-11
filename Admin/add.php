<!DOCTYPE html>
<head></head>
<body>
  <?php
  require_once('config.php') ;
  session_start();
  $res = $_GET['entry_id'];
  $name = $_POST['rolename'];
    isset($_POST['r']) ? $read = 1 : $read = 0;
    isset($_POST['w']) ? $write = 1 : $write = 0;
    isset($_POST['e']) ? $execute = 1 : $execute = 0;
    isset($_POST['d']) ? $delete = 1: $delete = 0;
    isset($_POST['c']) ? $create = 1:  $create = 0;
    
    echo"$res, $read, $write, $execute, $delete, $create";
    
    $q2="call AddPerm('$name', '$res', '$read', '$write', '$execute', '$delete', '$create')";
    $result2= mysqli_query($conn, $q2);
    
    if(!$result2){
        echo "Add failed. Error: ".$mysqli->error ;
        return false;
    }    
    echo "<script>window.close();</script>";
   
?>      
</body>
</html>
