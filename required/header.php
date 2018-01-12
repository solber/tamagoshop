<?php 
if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$entryexi = 0;
if (isset($_SESSION['auth']->id))
{
  require_once 'required/database.php';
  $req = $pdo->prepare('SELECT id FROM op_user WHERE user_id = ?');
  $req->execute([intval($_SESSION['auth']->id)]);
  $entryexi = $req->fetch();
}
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
              echo '<li><a href="account.php">Account</a></li>';
              echo '<li><a href="logout.php">Signout</a></li>';
              if ($_SESSION['auth']->username === "solber" || $entryexi)
                echo '<li><a href="manage_product.php">Manage</a></li>';
            }
            else
            {
              echo '<li><a href="login.php">Signin</a></li>';
              echo '<li><a href="register.php">Signup</a></li>';
            }
      ?>
      <li><a class="active" href="cart.php">Cart</a></li>
    </ul>
  </div>