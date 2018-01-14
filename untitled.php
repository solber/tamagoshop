<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['auth']['id'])) 
{
	$_SESSION['flash']['danger'] = "You cannot access this page.";
	header('Location: index.php');
	exit();
}

















?>