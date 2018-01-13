<center><p>
	<?php
		require_once 'database.php';
		if (mysqli_connect_errno()) {
 			echo "Could  not connect to database: Error: ".mysqli_connect_error();
    		exit();
		}

		if ($req = mysqli_query($mysqli, 'SELECT * FROM categories_ref'))
		{
			while ($row = mysqli_fetch_assoc($req))
			{
				echo '- <a href="index.php?cat=' .$row['id'] .'" style="color: grey;">' .$row['name'] .'</a> -';
			}
		}
	?>
</p></center>
<br>