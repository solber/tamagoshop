<center><p>
	<?php
		require_once 'database.php';

		$req = $pdo->query('SELECT * FROM categories_ref');
		foreach ($req as $key) {
			echo '- <a href="index?cat=' .$key->id .'" style="color: grey;">' .$key->name .'</a> -';
		}
	?>
</p></center>
<br>