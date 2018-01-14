<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	
	if (isset($_GET))
	{
		if (isset($_GET['id']))
		{
			if (is_numeric($_GET['id']))
			{
				require_once 'required/database.php';
				if ($req = mysqli_query($mysqli, "SELECT * FROM products WHERE id=" .intval($_GET['id'])))
				{
					if ($entryexi = mysqli_fetch_assoc($req))
					{
						if ($entryexi['qty'] > 0)
						{
							if (!isset($_SESSION['cart']))
							$_SESSION['cart'] = array();
							$place = 0;
							while (isset($_SESSION['cart'][$place]))
								$place++;
							$item = intval($_GET['id']);
							$_SESSION['cart'][$place] = $item;
							$_SESSION['flash']['info'] = "Item added to cart.";
							header('Location: index.php');
							exit();
						}
						else
						{
							$_SESSION['flash']['danger'] = "Item out of stock.";
							header('Location: index.php');
							exit();
						}	
					}
				}
			}
		}
	}
?>