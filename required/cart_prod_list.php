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
		}

		if (isset($_SESSION['cart']))
		{
			$all = array();
			$curr = array();
			$nb_curr = array();
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
						echo '<form method="POST">';
							echo '<img src="' .$product_info->img .'" alt="img">';
							echo '<h3>' .$product_info->name .'</h3>';
							echo '<h2>' .$product_info->price .'<h2>';
							echo '<input type="number" min="0" value="' .$value .'">';
						if (isset($_SESSION['auth']->id))
							echo '<input type="submit" name="buybtn" value="Buy">';
						echo '</form>';
					echo '</div></center>'; 
					$total += ($product_info->price * $value);
				}		
			}
			//echo $total;
			echo '<center><h1 style="color: orange;">Total : $' .$total .'</h1></center>';
		}
		

?>