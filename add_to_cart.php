<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	
	if (isset($_GET))
	{
		if (isset($_GET['id']))
		{
			if (is_numeric($_GET['id']))
			{
				if (!isset($_SESSION['cart']))
					$_SESSION['cart'] = array();
				$place = 0;
				while (isset($_SESSION['cart'][$place]))
					$place++;
				$item = intval($_GET['id']);
				$_SESSION['cart'][$place] = intval($_GET['id']);
				$_SESSION['flash']['info'] = "Item added to cart.";
				header('Location: index.php');
				exit();
			}
		}
	}
?>