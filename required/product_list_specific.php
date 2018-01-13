<?php
if (isset($_GET))
{
	if (isset($_GET['cat']))
	{
		require_once 'database.php';
		if ($req = mysqli_query($mysqli, "SELECT * FROM prod_categorie WHERE cat_id='" .intval($_GET['cat']) ."'"))
		{
			while ($row = mysqli_fetch_assoc($req))
			{
				if ($reqprod = mysqli_query($mysqli, "SELECT * FROM products WHERE id='" .intval($row['prod_id']) ."'"))
				{
					while ($row = mysqli_fetch_assoc($reqprod))
					{
						echo '<li>
								<a href="add_to_cart.php?id=' .intval($row['id']) .'">
									<img class="product-img" src="' .$row['img'] .'">
									<center><h4 class="title">' .$row['name'] .'</h4><center>
								</a>
								<center><p class="price">$'.$row['price'] .'</p><center>    
							</li>';
					}		
				}
			}
		}
	}
}

?>
