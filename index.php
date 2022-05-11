<!DOCTYPE html>
<!--Await for bug squashing-->
<head>
  <title> Menu - Access Control System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Include Bootstrap 5 from a CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<div class="container-fluid" id="header">
  <h1>Main Page</h1>
</div>
<div class="container-fluid" id="menu">
  <div class="row" style="height: 5vw;">
    <div class="col-5"><a href="User/login_user.php"><button id="s" type="submit" name="User" >User</button></a></div> 
    <div class="col-2"></div>
    <div class="col-5"><a href="Admin/login_admin.php"><button id="s" type="submit" name="Role" >Admin</button></a></div> 
  </div>
</div>

</body>
</html>