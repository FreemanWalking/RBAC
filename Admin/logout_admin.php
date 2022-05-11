<?php 

session_start();
unset($_SESSION['E_email_admin']);

header("Location: login_admin.php");

?>