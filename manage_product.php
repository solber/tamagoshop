<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['auth']->id) || $_SESSION['auth']->username != "solber") 
{
	$_SESSION['flash']['danger'] = "You cannot acces this page.";
	header('Location: index.php');
	exit();
}


if (!empty($_POST))
{
	//adding product
	if (isset($_POST['addbtn']))
	{
		if (empty($_POST['name']) || empty($_POST['price']) || !preg_match('/^[0-9,]+$/', $_POST['price']))
		{
			
			$_SESSION['flash']['danger'] = "Error wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			if ($req = $pdo->query("INSERT INTO `products` (`id`, `name`, `price`, `img`) VALUES (NULL, '".$_POST['name'] ."', '" .floatval($_POST['price']) ."', '')"))
			{
				$_SESSION['flash']['success'] = "Item added";
				header('Location: manage_product.php');
				exit();
			}
			else
			{
				$_SESSION['flash']['danger'] = "Error can't add item";
				header('Location: manage_product.php');
				exit();
			}
		}
	}

	//modifying product
	if (isset($_POST['modbtn']))
	{
		if (empty($_POST['modid']) || empty($_POST['modname']) || empty($_POST['modprice']) || !preg_match('/^[0-9]+$/', $_POST['modid']) || !preg_match('/^[0-9,]+$/', $_POST['modprice']))
		{
			$_SESSION['flash']['danger'] = "Error wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = $pdo->prepare('SELECT id FROM products WHERE id = ?');
	        $req->execute([intval($_POST['modid'])]);
	        $entryexi = $req->fetch();
	        if ($entryexi)
	        {
				$sql = "UPDATE products SET name='".$_POST['modname']."', price='".floatval($_POST['modprice'])."' WHERE id='".$_POST['modid']."'";
				if ($req = $pdo->query($sql))
				{
					$_SESSION['flash']['success'] = "Item modified";
					header('Location: manage_product.php');
					exit();
				}
				else
				{
					$_SESSION['flash']['danger'] = "Error can't modify";
					header('Location: manage_product.php');
					exit();
				}
	        }
	        else
	        {
	        	$_SESSION['flash']['danger'] = "Error cant modify";
				header('Location: manage_product.php');
				exit();
	        }
			
		}
	}

	//Refer Ctegorie to product
	if (isset($_POST['rcbtn']))
	{
		if (empty($_POST['prodid']) || empty($_POST['catid']) || !preg_match('/^[0-9]+$/', $_POST['prodid']) || !preg_match('/^[0-9]+$/', $_POST['catid']))
		{
			$_SESSION['flash']['danger'] = "Error wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = $pdo->prepare('SELECT id FROM categories_ref WHERE id = ?');
	        $req->execute([intval($_POST['catid'])]);
	        $catexi = $req->fetch();

	        $req = $pdo->prepare('SELECT id FROM prod_categorie WHERE prod_id = ? AND cat_id = ?');
	        $req->execute([intval($_POST['prodid']), intval($_POST['catid'])]);
	        $entryexi = $req->fetch();
			if ($catexi && !$entryexi)
			{
				if ($req = $pdo->query("INSERT INTO prod_categorie SET prod_id='".intval($_POST['prodid'])."',cat_id=".intval($_POST['catid'])))
				{
					$_SESSION['flash']['success'] = "Item added to cat";
					header('Location: manage_product.php');
					exit();
				}
				else
				{
					$_SESSION['flash']['danger'] = "Error can't add to cat";
					header('Location: manage_product.php');
					exit();
				}	
			}
			else
			{
				$_SESSION['flash']['danger'] = "Error cat doseant exist or cat already definded for this product";
				header('Location: manage_product.php');
				exit();
			}
		}
	}

	//del cat to product
	if(isset($_POST['dcbtn']))
	{
		if (empty($_POST['delprodid']) || empty($_POST['delcatid']) || !preg_match('/^[0-9]+$/', $_POST['delcatid']) || !preg_match('/^[0-9]+$/', $_POST['delprodid']))
		{
			$_SESSION['flash']['danger'] = "Error wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = $pdo->prepare('SELECT id FROM prod_categorie WHERE prod_id = ? AND cat_id = ?');
	        $req->execute([intval($_POST['delprodid']), intval($_POST['delcatid'])]);
	        $entryexi = $req->fetch();
	        if ($entryexi)
	        {
	        	if ($req = $pdo->query("DELETE FROM prod_categorie WHERE prod_id ='" .intval($_POST['delprodid']) ."' AND cat_id ='" .intval($_POST['delcatid']) ."'"))
	        	{
	        		$_SESSION['flash']['success'] = "Item cat deleted";
					header('Location: manage_product.php');
					exit();
	        	}
	        	else
	        	{
	        		$_SESSION['flash']['danger'] = "Can't delete item cat";
					header('Location: manage_product.php');
					exit();
	        	}
	        }
	        else
	        {
	        	$_SESSION['flash']['danger'] = "Error wrong values.";
				header('Location: manage_product.php');
				exit();
	        }
		}
	}

	//deleting product
	if (isset($_POST['dellbtn']))
	{
		if (empty($_POST['delproductid']) || !preg_match('/^[0-9]+$/', $_POST['delproductid']))
		{
			$_SESSION['flash']['danger'] = "Error wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = $pdo->prepare('SELECT id FROM products WHERE id = ?');
	        $req->execute([intval($_POST['delproductid'])]);
	        $entryexi = $req->fetch();
	        if ($entryexi)
	        {
	        	$req = $pdo->prepare('SELECT id FROM prod_categorie WHERE prod_id = ?');
		        $req->execute([intval($_POST['delproductid'])]);
		        $entryexi = $req->fetch();
		        if ($entryexi > 0)
		        {
		        	if (!($req = $pdo->query("DELETE FROM prod_categorie WHERE prod_id ='" .intval($_POST['delproductid']) ."'")))
		        	{
		        		$_SESSION['flash']['danger'] = "Can't delete item";
						header('Location: manage_product.php');
						exit();
		        	}
		        	if ($req = $pdo->query("DELETE FROM products WHERE id ='" .intval($_POST['delproductid']) ."'"))
		        	{
		        		$_SESSION['flash']['success'] = "item and item cat deleted";
						header('Location: manage_product.php');
						exit();
		        	}
		        	else
		        	{
		        		$_SESSION['flash']['danger'] = "Can't delete item";
						header('Location: manage_product.php');
						exit();
		        	}
		        }
		        else
		        {
		        	$_SESSION['flash']['danger'] = "Can't delete item";
					header('Location: manage_product.php');
					exit();
		        }
	        }
	        else
	        {
	        	$_SESSION['flash']['danger'] = "Can't delete item";
				header('Location: manage_product.php');
				exit();
	        }
		}
	}

	//adding cat
	if (isset($_POST['addcbtn']))
	{
		if (empty($_POST['addcname']) || !preg_match('/^[a-zA-Z]+$/', $_POST['addcname']))
		{
			$_SESSION['flash']['danger'] = "Error wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = $pdo->prepare('SELECT id FROM categories_ref WHERE name = ?');
		    $req->execute([$_POST['addcname']]);
		    $entryexi = $req->fetch();
		    if ($entryexi > 0)
		    {
		    	$_SESSION['flash']['danger'] = "cat cant be added";
				header('Location: manage_product.php');
				exit();
		    }
		    else
		    {
		    	if ($req = $pdo->query("INSERT INTO categories_ref SET name ='" .$_POST['addcname'] ."'"))
				{
					$_SESSION['flash']['success'] = "cat added";
					header('Location: manage_product.php');
					exit();
			    }
			    else
			    {
			    	$_SESSION['flash']['danger'] = "cat cant be added";
					header('Location: manage_product.php');
					exit();
			    }
		    }	
		}
	}

	//rm cat
	if (isset($_POST['rmcbtn']))
	{
		if (empty($_POST['rmcid']) || !preg_match('/^[0-9]+$/', $_POST['rmcid']))
		{
			$_SESSION['flash']['danger'] = "Error wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = $pdo->prepare('SELECT id FROM categories_ref WHERE id = ?');
		    $req->execute([intval($_POST['rmcid'])]);
		    $entryexi = $req->fetch();
		    if ($entryexi > 0)
		    {
		    	if ($req = $pdo->query("DELETE FROM categories_ref WHERE id='" .intval($_POST['rmcid']) ."'"))
		    	{
		    		$_SESSION['flash']['success'] = "cat del";
					header('Location: manage_product.php');
					exit();
		    	}
		    	else
		    	{
		    		$_SESSION['flash']['danger'] = "Error can't del cat";
					header('Location: manage_product.php');
					exit();
		    	}
		    }
		    else
		    {
		    	$_SESSION['flash']['danger'] = "Error can't del cat";
				header('Location: manage_product.php');
				exit();
		    }
		}
	}

	//modify cat
	if (isset($_POST['modcbtn']))
	{
		if (empty($_POST['modcname']) || empty($_POST['modcid']) || !preg_match('/^[a-zA-Z]+$/', $_POST['modcname']) || !preg_match('/^[0-9]+$/', $_POST['modcid']))
		{
			$_SESSION['flash']['danger'] = "Error wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = $pdo->prepare('SELECT id FROM categories_ref WHERE id = ?');
		    $req->execute([intval($_POST['modcid'])]);
		    $entryexi = $req->fetch();
		    if ($entryexi)
		    {
		    	require_once 'required/database.php';
				$sql = "UPDATE categories_ref SET name='".$_POST['modcname']."' WHERE id='".$_POST['modcid']."'";
				if ($req = $pdo->query($sql))
				{
					$_SESSION['flash']['success'] = "cat modified";
					header('Location: manage_product.php');
					exit();
				}
				else
			    {
			    	$_SESSION['flash']['danger'] = "Error can't modify cat";
			    	header('Location: manage_product.php');
					exit();
			    }
			}
			else
			{
				$_SESSION['flash']['danger'] = "Error can't modify";
				header('Location: manage_product.php');
				exit();
			}   
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/administration.css">
	<title>Manage Products</title>
</head>
<body>
	<div class="header">
		<h1 class="title">Administration Page</h1>
	</div>
	<div class="container">
		<?php require_once 'required/flash.php'; ?>
		<div style="border: 1px solid black; margin: 5px; padding: 5px;">
			<label>Add Product</label>
			<form method="POST">
				<input type="text" name="name" placeholder="name">
				<input type="text" name="price" placeholder="price">
				<input type="submit" name="addbtn" value="Valider">
			</form>
			<label>Modify Product</label>
			<form method="POST">
				<input type="text" name="modid" placeholder="id">
				<input type="text" name="modname" placeholder="name">
				<input type="text" name="modprice" placeholder="price">
				<input type="submit" name="modbtn" value="Valider">
			</form>
			<label>Refer Categorie to Product</label>
			<form method="POST">
				<input type="text" name="prodid" placeholder="prodid">
				<input type="text" name="catid" placeholder="catid">
				<input type="submit" name="rcbtn" value="Valider">
			</form>
			<label>del Categorie to Product</label>
			<form method="POST">
				<input type="text" name="delprodid" placeholder="prodid">
				<input type="text" name="delcatid" placeholder="catid">
				<input type="submit" name="dcbtn" value="Valider">
			</form>
			<label>Delete Product</label>
			<form method="POST">
				<input type="text" name="delproductid" placeholder="id">
				<input type="submit" name="dellbtn" value="Valider">
			</form>
		</div>
		<div style="border: 1px solid black; margin: 5px; padding: 5px;">
			<label>Add cat</label>
			<form method="POST">
				<input type="text" name="addcname" placeholder="name">
				<input type="submit" name="addcbtn" value="Valider">
			</form>
			<label>rm cat</label>
			<form method="POST">
				<input type="text" name="rmcid" placeholder="id">
				<input type="submit" name="rmcbtn" value="Valider">
			</form>
			<label>mod cat</label>
			<form method="POST">
				<input type="text" name="modcname" placeholder="name">
				<input type="text" name="modcid" placeholder="catid">
				<input type="submit" name="modcbtn" value="Valider">
			</form>
		</div>
		<br>
		<table class="tbla" style="border: 1px solid black;">
			<tr><td>prodid</td><td>prodname</td><td>prodprice</td></tr>
			<?php
				require_once 'required/database.php';
				$req = $pdo->query('SELECT * FROM products');
				foreach ($req as $row) {
					echo "<tr><td>$row->id</td><td>$row->name</td><td>$row->price</td></tr>";
				}
			?>
		</table>
		<br>
		<table class="tblb" style="border: 1px solid black;">
			<tr><td>prodid</td><td>prodcatid</td></tr>
			<?php
				require_once 'required/database.php';
				$req = $pdo->query('SELECT * FROM prod_categorie');
				foreach ($req as $row) {
					echo "<tr><td>$row->prod_id</td><td>$row->cat_id</td></tr>";
				}
			?>
		</table>
		<table class="tblc" style="border: 1px solid black;">
			<tr><td>refid</td><td>name</td></tr>
			<?php
				require_once 'required/database.php';
				$req = $pdo->query('SELECT * FROM categories_ref');
				foreach ($req as $row) {
					echo "<tr><td>$row->id</td><td>$row->name</td></tr>";
				}
			?>
		</table>
	</div>
</body>
</html>