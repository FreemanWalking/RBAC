<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "rbac";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
function isLoginSessionExpired($conn) {
    $E_email_user = $_SESSION['E_email_user'];
    $sql = "SELECT * FROM user WHERE Email='$E_email_user'";
    $result = mysqli_query($conn, $sql);
    $userName = mysqli_fetch_array($result);
  
    $sql_1 = "SELECT * FROM user_role WHERE UserID='$userName[UserID]'";
    $result_1 = mysqli_query($conn, $sql_1);
    $roleId = mysqli_fetch_array($result_1);
  
    $sql_2 = "SELECT * FROM role WHERE RoleID='$roleId[RoleID]'";
    $result_2 = mysqli_query($conn, $sql_2);
    $role = mysqli_fetch_array($result_2);
  
    date_default_timezone_set("Asia/Bangkok");
    $current_time = date("h:i:s"); 
    $from = $role['Allowed_time'];
    $to = $role['Allowed_time_end'];
    if($current_time >= $from && $current_time <= $to){
      return false; 
    }
    else{
      return true;
    }
  }
?>