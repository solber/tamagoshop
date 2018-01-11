<?php 
if (session_status() == PHP_SESSION_NONE) { session_start(); } 

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <title>TamagoShop</title>
</head>

<body>

  <div class="header">
    <center><img class="img-logo" src="img/TamagoShop.png" title="logo" alt="Logo"></center>
    <ul>
      <li><a class="active" href="index.php">Home</a></li>
      <?php if (isset($_SESSION['auth']->id))
            {
              echo '<li><a href="logout.php">Signout</a></li>';
              if ($_SESSION['auth']->username === "solber")
                echo '<li><a href="manage_product.php">Manage</a></li>';
            }
            else
            {
              echo '<li><a href="login.php">Signin</a></li>';
              echo '<li><a href="register.php">Signup</a></li>';
            }
      ?>
    </ul>
  </div>