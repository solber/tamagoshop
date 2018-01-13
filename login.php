<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['auth']['id'])) 
{
	$_SESSION['flash']['danger'] = "You cannot acces this page.";
	header('Location: index.php');
	exit();
}

if (!empty($_POST))
{
		//login
		//verif field
		if(empty($_POST['logusername']) && empty($_POST['logpsw'])){
	        $_SESSION['flash']['danger'] = "Please fill all field !"; 
	        header('Location: login.php');
	        exit();
	    }

	    //verif usernaame
	    if(empty($_POST['logusername'])){
	        $_SESSION['flash']['danger'] = "Please fill username field."; 
	        header('Location: login.php');
	    	exit();
	    }

	    //verif psw
	    if(empty($_POST['logpsw'])){
	        $_SESSION['flash']['danger'] = "Please fill password field."; 
	        header('Location: login.php');
	        exit();
	    }

	    //login in
	    require_once 'required/database.php';
	    $pusername = mysqli_real_escape_string($mysqli, $_POST['logusername']);
	    $ppsw = mysqli_real_escape_string($mysqli, $_POST['logpsw']);

        if ($req = mysqli_query($mysqli, "SELECT * FROM users WHERE username='" .$pusername ."'"))
        {
        	$user = mysqli_fetch_assoc($req);

	        if(password_verify($ppsw, $user['password'])){
	            $_SESSION['auth'] = $user;
	            $_SESSION['flash']['success'] = "Connexion réussie !";
	            header('Location: index.php');
	            exit();
	        }else{
	            $_SESSION['flash']['danger'] = "Invalid username or password !";
	            header('Location: login.php');
	            exit();
	        }
    	}
    	else
    	{
    		$_SESSION['flash']['danger'] = "username doesent exist";
	        header('Location: login.php');
	        exit();
    	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/register.css">
	<title>Login</title>
</head>
<body>
	<div class="content">
		<a style="top: 8px; left: 16px;" href="index.php">< Go back to index</a>
		<a style="top: 8px; right: 16px;" href="register.php">Create account</a>
		<img class="logo" src="img/TamagoSHOP.png">
		<?php require_once 'required/flash.php'; ?>

		<form method="POST">
			<center><input style="margin-top: 10%;" type="text" name="logusername" placeholder="Login"></center>
			<br>
			<center><input type="password" name="logpsw" placeholder="Password"/></center>
			<br>
			<center><button class="btn" name="logbtn" value="login">LOGIN</button></center>
		</form>
	</div>

</body>
</html>