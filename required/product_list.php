<?php
	require_once 'database.php';

	$req = $pdo->query('SELECT * FROM products');
	foreach ($req as $key) {
		echo '<li>
			<a href="add_to_cart.php?id=' .intval($key->id) .'">
				<img class="product-img" src="' .$key->img .'">
				<center><h4 class="title">' .$key->name .'</h4><center>
			</a>
			<center><p class="price">$'.$key->price .'</p><center>    
		</li>';
	}

?>
