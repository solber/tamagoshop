<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['auth']['id']) || $_SESSION['auth']['candraw'] <= 0) 
{
	$_SESSION['flash']['danger'] = "You cannot access this page.";
	header('Location: index.php');
	exit();
}

$res = 0;
if (!empty($_POST))
{
	require_once 'required/database.php';
	$nb = $_SESSION['auth']['candraw'] - 1;
	$req = mysqli_query($mysqli, "UPDATE users SET candraw=" .intval($nb) ." WHERE id=" .intval($_SESSION['auth']['id']));
	$_SESSION['auth']['candraw'] = $nb;
	if ($_POST['card'] == 1)
	{
		$res = 1;
		$req = mysqli_query($mysqli, "UPDATE users SET candraw='0' WHERE id=" .intval($_SESSION['auth']['id']));
		$_SESSION['auth']['candraw'] = 0;
	}
}

?>

<?php include('required/header.php'); ?>
	<div class="container">
		<?php require_once 'required/flash.php'; ?>
		<?php if ($_SESSION['auth']['candraw'] > 0 && $res == 0)
		{ ?>
			<center>
				<h1>Choose a card !</h1>
				<div class="cards">
					<?php

					$nb_cards = 5;
					while ($nb_cards > 0)
					{
						$chance = random_int(0, 1);
						echo '<form method="POST" action="coupon.php">';
							echo '<input type="image" src="img/card.jpg" name="card" title="card" alt="card" width="90%" value="' .$chance .'"/>';
						echo '</form>';
						$nb_cards--;	
					}
					?>
				</div>
			</center>
		<?php }else if ($res == 1) {?>
						<center><h1>Hey ! Your coupon is : 42born2code</h1></center>
		<?php } ?>
	</div>
</body>
</html>