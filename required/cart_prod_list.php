<?php
		if(session_status() == PHP_SESSION_NONE){ session_start(); }
		

		if (!empty($_POST))
		{
			if (isset($_POST['delbtn']))
			{
				unset($_SESSION['cart']);
				header('Location: cart.php');
				exit();
			}

			if (isset($_POST['buybtn']))
			{
				require_once 'required/database.php';
				require_once 'required/functions.php';
				
				$order_id = str_random(60);

				foreach ($_SESSION['bought'] as $key => $value) {
					if (!($req = $pdo->query("INSERT INTO orders (id, buyer_id, cmd_id, product, qty, total_cmd) VALUES (NULL, '" .intval($_SESSION['auth']->id) ."', '" .$order_id ."', '" .intval($key) ."', '" .intval($value) ."', '" .floatval($_POST['total']) ."')")))
					{
						$_SESSION['flash']['danger'] = "Error while processing to order.";
						header('Location: cart.php');
						exit();
					}
				}
				$_SESSION['flash']['success'] = "Order success.";
				unset($_SESSION['cart']);
				unset($_SESSION['bought']);
				header('Location: cart.php');
				exit();
			}
		}

		if (isset($_SESSION['cart']))
		{
			$all = array();
			$curr = array();
			foreach ($_SESSION['cart'] as $products) {
				$all[] .= $products;
			}
			foreach ($all as $key => $value) {
				if (!array_key_exists($value, $curr))
				$curr[$value] = '0';
			}
			foreach ($all as $key => $val) {
				$curr[$val] += 1;
			}
			$_SESSION['bought'] = array();
			$_SESSION['bought'] = $curr;
		//var_dump($curr);
			require_once 'required/database.php';
			$total = 0;
			echo '<center><form method="POST">';
				echo '<input type="submit" name="delbtn" value="Delete all">';
			echo '</form></center>';
			echo '<br>';
			foreach ($curr as $key => $value) {
				$req = $pdo->query('SELECT * FROM products WHERE id=' .intval($key));
				$product_info = $req->fetch();
				if ($product_info)
				{
						echo '<center><div class="cart-product">';
							echo '<img src="' .$product_info->img .'" alt="img">';
							echo '<h3>' .$product_info->name .'</h3>';
							echo '<h2>' .$product_info->price .'<h2>';
							echo '<h2 style="right: -100px">QTY : ' .$value .'</h2>';
						echo '</div></center>'; 
					$total += ($product_info->price * $value);
				}		
			}
			//echo $total;
			echo '<form method="POST">';
				if (isset($_SESSION['auth']->id))
				{
					echo '<input name="total" type="text" style="visibility: hidden" value="' .floatval($total) .'">';
					echo '<center><input type="submit" name="buybtn" value="Buy" style="width: 200px; height: 30px;"></center>';	
				}
			echo '</form>';
			echo '<center><h1 style="color: orange;">Total : $' .$total .'</h1></center>';
		}
?>