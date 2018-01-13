<?php 
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	if (!isset($_SESSION['auth'])) 
	{
		$_SESSION['flash']['danger'] = "You cannot access this page.";
	}
	else
	{
		unset($_SESSION['auth']); 
	}
	header('Location: index.php');
	exit();
?>