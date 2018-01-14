<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['auth']['id'])) 
{
	$_SESSION['flash']['danger'] = "You cannot access this page.";
	header('Location: index.php');
	exit();
}


if (!empty($_POST))
{
	if ($_POST['deletebtn'] === "delete")
	{
		require_once 'required/database.php';
		if ($req = mysqli_query($mysqli, 'DELETE FROM users WHERE id=' .intval($_SESSION['auth']['id'])))
		{
			unset($_SESSION['auth']);
			if (isset($_SESSION['cart']))
				unset($_SESSION['cart']);
			$_SESSION['flash']['success'] = "Account deleted.";
			header('Location: index.php');
			exit();	
		}
		else
		{
			$_SESSION['flash']['danger'] = "Error while deleting account.";
			header('Location: account.php');
			exit();	
		}
		
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/register.css">
	<title>Account</title>
</head>
<body>
	<div class="content">
		<a style="top: 8px; left: 16px;" href="index.php">< Go back to index</a>
		<img class="logo" src="img/TamagoSHOP.png">
		<?php require_once 'required/flash.php'; ?>

		<form method="POST">
			<br><br>
			<center><button class="btn" name="deletebtn" value="delete">DELETE MY ACCOUNT</button></center>
		</form>
	</div>

</body>
</html>