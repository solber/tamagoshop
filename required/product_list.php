<?php
	require_once 'database.php';

	if ($req = mysqli_query($mysqli, 'SELECT * FROM products'))
	{
		while ($row = mysqli_fetch_assoc($req)) {
        	echo '<li>
					<a href="add_to_cart.php?id=' .intval($row['id']) .'">
						<img class="product-img" src="' .$row['img'] .'">
						<center><h4 class="title">' .$row['name'] .'</h4><center>
					</a>
					<center><p class="price">$'.$row['price'] .'</p><center>    
				</li>';
    	}
	}

?>
