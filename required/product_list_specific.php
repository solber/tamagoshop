<?php
if (isset($_GET))
{
	if (isset($_GET['cat']))
	{
		require_once 'database.php';

		$req = $pdo->query("SELECT * FROM prod_categorie WHERE cat_id='" .intval($_GET['cat']) ."'");
		foreach ($req as $key) {
			$reqprod = $pdo->query("SELECT * FROM products WHERE id='" .$key->prod_id ."'");
			foreach ($reqprod as $key) {
				echo '<li>
					<a href="add_to_cart.php?id=' .intval($key->id) .'">
						<img class="product-img" src="' .$key->img .'">
						<center><h4 class="title">' .$key->name .'</h4><center>
					</a>
					<center><p class="price">$'.$key->price .'</p><center>    
				</li>';
			}
		}
	}
}

?>
