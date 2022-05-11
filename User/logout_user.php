<?php 

session_start();
unset($_SESSION['E_email_user']);

header("Location: login_user.php");

?>