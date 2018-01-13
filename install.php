<?php
	//require_once 'required/database.php';
try
{
	$host = "localhost";
	$user = "root";
	$password = "test";

	$mysqli   = mysqli_connect($host, $user, $password);

	if (mysqli_connect_errno($mysqli)) {
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$req = mysqli_query($mysqli, "DROP DATABASE IF EXISTS 'rush';");
	$req = mysqli_query($mysqli, "CREATE DATABASE rush DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci");
	$req = mysqli_query($mysqli, 'use rush;');
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `categories_ref`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `categories_ref` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `name` varchar(255) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "INSERT INTO `categories_ref` (`id`, `name`) VALUES
									(6, 'Blue'),
									(7, 'Red'),
									(8, 'Orange'),
									(9, 'Purple'),
									(10, 'Familly');");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `op_user`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `op_user` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `user_id` int(11) NOT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `orders`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `orders` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `buyer_id` int(11) NOT NULL,
							  `cmd_id` varchar(255) NOT NULL,
							  `product` int(11) NOT NULL,
							  `qty` int(11) NOT NULL,
							  `total_cmd` float NOT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `products`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `products` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `name` varchar(255) NOT NULL,
								  `price` float(10,2) NOT NULL,
								  `img` varchar(255) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "INSERT INTO `products` (`id`, `name`, `price`, `img`) VALUES
								(18, 'Red Tamagotchi', 4.00, 'img/red.jpg'),
								(19, 'Blue Tamagotchi', 5.00, 'img/blue.jpg'),
								(20, 'Orange Tamagotchi', 2.00, 'img/orange.jpg'),
								(21, 'Purple Tamagotchi', 4.50, 'img/purple.jpg'),
								(22, 'Blue Tamagotchi Family', 10.00, 'img/family-blue.jpg'),
								(23, 'Green Tamagotchi Family', 10.00, 'img/family-green.jpg');");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `prod_categorie`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `prod_categorie` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `prod_id` int(11) NOT NULL,
								  `cat_id` int(11) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "INSERT INTO `prod_categorie` (`id`, `prod_id`, `cat_id`) VALUES
								(17, 18, 7),
								(18, 19, 6),
								(20, 20, 8),
								(21, 21, 9),
								(22, 22, 10),
								(23, 22, 6),
								(24, 23, 10);");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `users`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `users` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `username` varchar(255) NOT NULL,
							  `password` varchar(255) NOT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;");
	//$file = file_get_contents('req.sql');
	//$req = mysqli_query($mysqli, $file);
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	if (isset($_SESSION['auth']))
		unset($_SESSION['auth']);
	$_SESSION['flash']['success'] = "Database set.";
	header('Location: index.php');
	exit();
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>