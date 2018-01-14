<?php 
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	if (!isset($_SESSION['auth'])) 
	{
		$_SESSION['flash']['danger'] = "You cannot access this page.";
	}
	else
	{
		unset($_SESSION['auth']); 
		if ($_SESSION['cart'])
			unset($_SESSION['cart']);
	}
	header('Location: index.php');
	exit();
?>