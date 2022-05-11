<?php 

$server = "us-cdbr-east-05.cleardb.net";
$user = "b95134a8b31d93";
$pass = "2c157723";
$database = "heroku_89873beb75ba2c3";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>