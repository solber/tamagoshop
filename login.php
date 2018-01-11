<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['auth']->id)) 
{
	$_SESSION['flash']['danger'] = "You cannot acces this page.";
	header('Location: index.php');
	exit();
}

require_once 'required/flash.php';

if (!empty($_POST))
{
	if(isset($_POST['login']))
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
        $req = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $req->execute(['username' => $_POST['logusername']]);
        $user = $req->fetch();

        if(password_verify($_POST['logpsw'], $user->password)){
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = "Connexion réussie !";
            header('Location: index.php');
            exit();
        }else{
            $_SESSION['flash']['danger'] = "Invalid username or password !";
            header('Location: index.php');
            exit();

        }
	}
	else
	{
		//register

		//verif field not empty
		if (empty($_POST['regusername']) || empty($_POST['regpsw']) || empty($_POST['regpswr']))
		{
			$_SESSION['flash']['danger'] = "Please fill all fields.";
			header('Location: login.php');
			exit();
		}

		//verif format username field
		if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['regusername']))
		{ 
			$_SESSION['flash']['danger'] = "Invalid username. Allowed char : a-z A-Z 0-9";
			header('Location: login.php');
			exit();
		}

		//verif psw are the same
		if ($_POST['regpsw'] != $_POST['regpswr'])
		{
			$_SESSION['flash']['danger'] = "Password must be the same.";
			header('Location: login.php');
			exit();
		}

		//verif psw size
		if (strlen($_POST['regpsw']) < 6 || strlen($_POST['regpsw']) > 10)
		{
			$_SESSION['flash']['danger'] = "Invalid password size. Minimum 6 Maximum 10.";
			header('Location: login.php');
			exit();
		}

		//Verify user exists
		require_once 'required/database.php';
        $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $req->execute([$_POST['regusername']]);
        $user = $req->fetch();
        if($user)
        {
        	$_SESSION['flash']['danger'] = "Username already taken.";
			header('Location: login.php');
			exit();
        }

        //register user
        require_once 'required/database.php';
        require_once 'required/functions.php';
        try
        {
	        $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?");
            $password = password_hash($_POST['regpsw'], PASSWORD_BCRYPT);
            $token = str_random(60);
           	$req->execute([$_POST['regusername'], $password]);

           	$user_id = $pdo->lastinsertid();
           	$_SESSION['flash']['success'] = "SUCCESS - Account created, please connect !";
           	header('Location: login.php');
            exit();
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>login</title>
</head>
<body>
	<label>Login</label>
	<form method="POST">
		<input type="text" name="logusername" placeholder="username">
		<input type="password" name="logpsw" placeholder="psw">
		<input type="submit" name="login" value="login">
	</form>
	<label>Register</label>
	<form method="POST">
		<input type="text" name="regusername" placeholder="username">
		<input type="password" name="regpsw" placeholder="psw">
		<input type="password" name="regpswr" placeholder="pswr">
		<input type="submit" name="register" value="register">
	</form>
</body>
</html>