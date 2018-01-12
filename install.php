<?php
	//require_once 'required/database.php';
try
{
	$pdo = new PDO('mysql:host=localhost', 'root', 'toor');
	$req = $pdo->exec("CREATE DATABASE rush DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci");
	$req = file_get_contents('req.sql');

	$req = $pdo->exec($req);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>