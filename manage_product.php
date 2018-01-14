<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['auth']['id'])) 
{
	$_SESSION['flash']['danger'] = "You cannot access this page.";
	header('Location: index.php');
	exit();
}

require_once 'required/database.php';
$req = mysqli_query($mysqli, "SELECT id FROM op_user WHERE user_id='" .intval($_SESSION['auth']['id']) ."'");
$entryexi = mysqli_fetch_assoc($req);
if (!$entryexi && $_SESSION['auth']['username'] != "solber")
{
	$_SESSION['flash']['danger'] = "You cannot access this page.";
	header('Location: index.php');
	exit();
}


if (!empty($_POST))
{

	//op user
	if (isset($_POST['opbtn']))
	{
		if (empty($_POST['opuser']))
		{
			$_SESSION['flash']['danger'] = "Error : Specify user";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = mysqli_query($mysqli, "SELECT id FROM users WHERE id='" .intval($_POST['opuser']) ."'");
	        $entryexi = mysqli_fetch_assoc($req);
	        if ($entryexi)
	        {
	        	$req = mysqli_query($mysqli, "SELECT id FROM op_user WHERE user_id='" .intval($_POST['opuser']) ."'");
		        $entryexi = mysqli_fetch_assoc($req);
		        if ($entryexi)
		        {
		        	$_SESSION['flash']['danger'] = "Error : User already op";
					header('Location: manage_product.php');
					exit();
		        }
		        else
		        {
		        	if ($req = mysqli_query($mysqli, "INSERT INTO `op_user` (`id`, `user_id`) VALUES (NULL, '".intval($_POST['opuser']) ."')"))
		        	{
						$_SESSION['flash']['success'] = "Success : User now op";
						header('Location: manage_product.php');
						exit();
		        	}
		        	else
		        	{
		        		$_SESSION['flash']['danger'] = "Error : Can't op this user";
						header('Location: manage_product.php');
						exit();
		        	}
		        }
	        }
	        else
	        {
	        	$_SESSION['flash']['danger'] = "Error : Wrong values or missing user";
				header('Location: manage_product.php');
				exit();
	        }
		}

	}

	//adding product
	if (isset($_POST['addbtn']))
	{
		if (empty($_POST['name']) || empty($_POST['price']) || !preg_match('/^[0-9.]+$/', $_POST['price']) || empty($_POST['img']) || empty($_POST['addqty']))
		{
			$_SESSION['flash']['danger'] = "Error : wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$pname = mysqli_real_escape_string($mysqli, $_POST['name']);
			$pimg = mysqli_real_escape_string($mysqli, $_POST['img']);
			if ($req = mysqli_query($mysqli, "INSERT INTO products SET name='" .$pname ."', price='".floatval($_POST['price']) ."', img='".$pimg ."', qty='".intval($_POST['addqty']) ."'"))
			{
				$_SESSION['flash']['success'] = "Success : Item added";
				header('Location: manage_product.php');
				exit();
			}
			else
			{
				$_SESSION['flash']['danger'] = "Error : can't add item";
				header('Location: manage_product.php');
				exit();
			}
		}
	}

	//modifying product
	if (isset($_POST['modbtn']))
	{
		if (empty($_POST['modid']) || empty($_POST['modname']) || empty($_POST['modprice']) || !preg_match('/^[0-9]+$/', $_POST['modid']) || !preg_match('/^[0-9.]+$/', $_POST['modprice']) || empty($_POST['modqty']))
		{
			$_SESSION['flash']['danger'] = "Error : wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = mysqli_query($mysqli, "SELECT id FROM products WHERE id='" .intval($_POST['modid']) ."'");
	        $entryexi = mysqli_fetch_assoc($req);
	        if ($entryexi)
	        {
				$sql = "UPDATE products SET name='".$_POST['modname']."', price='".floatval($_POST['modprice'])."', qty='".intval($_POST['modqty']) ."' WHERE id='".intval($_POST['modid']) ."'";
				if ($req = mysqli_query($mysqli, $sql))
				{
					$_SESSION['flash']['success'] = "Success : Item modified";
					header('Location: manage_product.php');
					exit();
				}
				else
				{
					$_SESSION['flash']['danger'] = "Error : can't modify";
					header('Location: manage_product.php');
					exit();
				}
	        }
	        else
	        {
	        	$_SESSION['flash']['danger'] = "Error : can't modify";
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
			$_SESSION['flash']['danger'] = "Error : wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = mysqli_query($mysqli, "SELECT id FROM categories_ref WHERE id='" .intval($_POST['catid']) ."'");
	        $catexi = mysqli_fetch_assoc($req);

	        $req = mysqli_query($mysqli, "SELECT id FROM prod_categorie WHERE prod_id='" .intval($_POST['prodid']) ."' AND cat_id='" .intval($_POST['catid']) ."'");
	        $entryexi = mysqli_fetch_assoc($req);
			if ($catexi && !$entryexi)
			{
				if ($req = mysqli_query($mysqli, "INSERT INTO prod_categorie SET prod_id='".intval($_POST['prodid'])."',cat_id=".intval($_POST['catid'])))
				{
					$_SESSION['flash']['success'] = "Success : Item added to category";
					header('Location: manage_product.php');
					exit();
				}
				else
				{
					$_SESSION['flash']['danger'] = "Error : can't add to category";
					header('Location: manage_product.php');
					exit();
				}	
			}
			else
			{
				$_SESSION['flash']['danger'] = "Error : category does not exists or category already defined for this product";
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
			$_SESSION['flash']['danger'] = "Error : wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = mysqli_query($mysqli, "SELECT id FROM prod_categorie WHERE prod_id ='".intval($_POST['delprodid']) ."' AND cat_id ='".intval($_POST['delcatid'])."'");
	        $entryexi = mysqli_fetch_assoc($req);
	        if ($entryexi)
	        {
	        	if ($req = mysqli_query($mysqli, "DELETE FROM prod_categorie WHERE prod_id ='" .intval($_POST['delprodid']) ."' AND cat_id ='" .intval($_POST['delcatid']) ."'"))
	        	{
	        		$_SESSION['flash']['success'] = "Success : Item category deleted";
					header('Location: manage_product.php');
					exit();
	        	}
	        	else
	        	{
	        		$_SESSION['flash']['danger'] = "Error : Can't delete item category";
					header('Location: manage_product.php');
					exit();
	        	}
	        }
	        else
	        {
	        	$_SESSION['flash']['danger'] = "Error : wrong values.";
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
			$_SESSION['flash']['danger'] = "Error : wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = mysqli_query($mysqli, "SELECT id FROM products WHERE id='".intval($_POST['delproductid'])."'");
	        $entryexi = mysqli_fetch_assoc($req);
	        if ($entryexi)
	        {
	        	$req = mysqli_query($mysqli, "SELECT id FROM products WHERE id='".intval($_POST['delproductid'])."'");
		        $entryexi = mysqli_fetch_assoc($req);
		        if ($entryexi)
		        {
		        	if (!($req = mysqli_query($mysqli, "DELETE FROM prod_categorie WHERE prod_id ='" .intval($_POST['delproductid']) ."'")))
		        	{
		        		$_SESSION['flash']['danger'] = "Error : Can't delete item";
						header('Location: manage_product.php');
						exit();
		        	}
		        	if ($req = mysqli_query($mysqli, "DELETE FROM products WHERE id ='" .intval($_POST['delproductid']) ."'"))
		        	{
		        		$_SESSION['flash']['success'] = "Success : deleted";
						header('Location: manage_product.php');
						exit();
		        	}
		        	else
		        	{
		        		$_SESSION['flash']['danger'] = "Error : Can't delete item";
						header('Location: manage_product.php');
						exit();
		        	}
		        }
		        else
		        {
		        	$_SESSION['flash']['danger'] = "Error : Can't delete item";
					header('Location: manage_product.php');
					exit();
		        }
	        }
	        else
	        {
	        	$_SESSION['flash']['danger'] = "Error : Can't delete item";
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
			$_SESSION['flash']['danger'] = "Error : wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$paddcname = mysqli_real_escape_string($mysqli, $_POST['addcname']);
			$req = mysqli_query($mysqli, "SELECT id FROM categories_ref WHERE name='".$paddcname."'");
		    $entryexi = mysqli_fetch_assoc($req);
		    if ($entryexi)
		    {
		    	$_SESSION['flash']['danger'] = "Error : category cant be added";
				header('Location: manage_product.php');
				exit();
		    }
		    else
		    {
		    	if ($req = mysqli_query($mysqli, "INSERT INTO categories_ref SET name ='" .$paddcname ."'"))
				{
					$_SESSION['flash']['success'] = "Success : category added";
					header('Location: manage_product.php');
					exit();
			    }
			    else
			    {
			    	$_SESSION['flash']['danger'] = "Error : category can't be added";
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
			$_SESSION['flash']['danger'] = "Error : wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = mysqli_query($mysqli, "SELECT id FROM categories_ref WHERE id='" .intval($_POST['rmcid']) ."'");
		    $entryexi = mysqli_fetch_assoc($req);
		    if ($entryexi)
		    {
		    	if ($req = mysqli_query($mysqli, "DELETE FROM categories_ref WHERE id='" .intval($_POST['rmcid']) ."'"))
		    	{
		    		$_SESSION['flash']['success'] = "Success : category deleted";
					header('Location: manage_product.php');
					exit();
		    	}
		    	else
		    	{
		    		$_SESSION['flash']['danger'] = "Error : can't delete category";
					header('Location: manage_product.php');
					exit();
		    	}
		    }
		    else
		    {
		    	$_SESSION['flash']['danger'] = "Error : can't delete category";
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
			$_SESSION['flash']['danger'] = "Error : wrong values";
			header('Location: manage_product.php');
			exit();
		}
		else
		{
			require_once 'required/database.php';
			$req = mysqli_query($mysqli, "SELECT id FROM categories_ref WHERE id='" .intval($_POST['modcid'])."'");
		    $entryexi = mysqli_fetch_assoc($req);
		    if ($entryexi)
		    {
		    	require_once 'required/database.php';
		    	$pmodcname = mysqli_real_escape_string($mysqli, $_POST['modcname']);
				$sql = "UPDATE categories_ref SET name='".$pmodcname ."' WHERE id='".intval($_POST['modcid']) ."'";
				if ($req = mysqli_query($mysqli, $sql))
				{
					$_SESSION['flash']['success'] = "Success : category modified";
					header('Location: manage_product.php');
					exit();
				}
				else
			    {
			    	$_SESSION['flash']['danger'] = "Error : can't modify category";
			    	header('Location: manage_product.php');
					exit();
			    }
			}
			else
			{
				$_SESSION['flash']['danger'] = "Error : can't modify";
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
	<link rel="stylesheet" type="text/css" href="css/register.css">
	<link rel="stylesheet" type="text/css" href="css/administration.css">
	<title>Administration</title>
</head>
<body>
	<div class="content">
		<a style="top: 8px; left: 16px;" href="index.php">< Go back to index</a>
		<img class="logo" src="img/TamagoSHOP.png">
		<?php require_once 'required/flash.php'; ?>

		<div style="border: 1px solid black; margin: 5px; padding: 5px; background: rgba(0, 0, 0, 0.1);">
			<label>OP user</label>
			<form method="POST">
				<input type="number" name="opuser" placeholder="userid">
				<input type="submit" name="opbtn" value="op">
			</form>
		</div>
		<div style="border: 1px solid black; margin: 5px; padding: 5px; background: rgba(0, 0, 0, 0.1);">
			<label>Add Product</label>
			<form method="POST">
				<input type="text" name="name" placeholder="name">
				<input type="text" name="price" placeholder="price">
				<input type="text" name="img" placeholder="ex: img/file.jpg">
				<input type="number" name="addqty" min='0' placeholder="10">
				<input type="submit" name="addbtn" value="Valider">
			</form>
			<label>Modify Product</label>
			<form method="POST">
				<input type="number" name="modid" placeholder="id">
				<input type="text" name="modname" placeholder="name">
				<input type="text" name="modprice" placeholder="price">
				<input type="number" name="modqty" min='0' placeholder="10">
				<input type="submit" name="modbtn" value="Valider">
			</form>
			<label>Refer Categorie to Product</label>
			<form method="POST">
				<input type="number" name="prodid" placeholder="prodid">
				<input type="number" name="catid" placeholder="catid">
				<input type="submit" name="rcbtn" value="Valider">
			</form>
			<label>del Categorie to Product</label>
			<form method="POST">
				<input type="number" name="delprodid" placeholder="prodid">
				<input type="number" name="delcatid" placeholder="catid">
				<input type="submit" name="dcbtn" value="Valider">
			</form>
			<label>Delete Product</label>
			<form method="POST">
				<input type="number" name="delproductid" placeholder="id">
				<input type="submit" name="dellbtn" value="Valider">
			</form>
		</div>
		<div style="border: 1px solid black; margin: 5px; padding: 5px; background: rgba(0, 0, 0, 0.1);">
			<label>Add cat</label>
			<form method="POST">
				<input type="text" name="addcname" placeholder="name">
				<input type="submit" name="addcbtn" value="Valider">
			</form>
			<label>rm cat</label>
			<form method="POST">
				<input type="number" name="rmcid" placeholder="id">
				<input type="submit" name="rmcbtn" value="Valider">
			</form>
			<label>mod cat</label>
			<form method="POST">
				<input type="text" name="modcname" placeholder="name">
				<input type="number" name="modcid" placeholder="catid">
				<input type="submit" name="modcbtn" value="Valider">
			</form>
		</div>
		<div class="tbl-container">
			<table class="blueTable">
				<caption>Products</caption>
				<thead>
					<tr>
						<th>ID</th>
						<th>NAME</th>
						<th>PRICE</th>
						<th>QTY</th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM products');
						while ($row = mysqli_fetch_assoc($req)) {
							echo "<tr><th>" .$row['id'] ."</th><th>" .$row['name'] ."</th><th>" .$row['price'] ."</th><th>" .$row['qty'] ."</th></tr>";
						}
					?>
				</tbody>
			</table>
			<table class="blueTable" style="position: absolute; left: 330px">
				<caption>Products Category</caption>
				<thead>
					<tr>
						<th>PROD_ID</th>
						<th>CAT_ID</th>
					</tr>
				</thead>
				<tbody> 
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM prod_categorie');
						while ($row = mysqli_fetch_assoc($req)) {
							echo "<tr><th>" .$row['prod_id'] ."</th><th>" .$row['cat_id'] ."</th></tr>";
						}
					?>
				</tbody>
			</table>
			<table class="blueTable" style="position: absolute; left: 650px;">
				<caption>Category</caption>
				<thead>
					<tr>
						<th>ID</th>
						<th>NAME</th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM categories_ref');
						while ($row = mysqli_fetch_assoc($req)) {
							echo "<tr><th>" .$row['id'] ."</th><th>" .$row['name'] ."</th></tr>";
						}
					?>
				</tbody>
			</table>
			<table class="blueTable" style="position: absolute; left: 970px;">
				<caption>Users</caption>
				<thead>
					<tr>
						<th>ID</th>
						<th>NAME</th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM users');
						while ($row = mysqli_fetch_assoc($req)) {
							echo "<tr><th>" .$row['id'] ."</th><th>" .$row['username'] ."</th></tr>";
						}
					?>
				</tbody>
			</table>
			<table class="blueTable" style="position: absolute; left: 1290px;">
				<caption>Orders</caption>
				<thead>
					<tr>
						<th>CMD_ID</th>
						<th>BUYER_ID</th>
						<th>PRODUCT</th>
						<th>QTY</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM orders');
						while ($row = mysqli_fetch_assoc($req)) {
							$order_id = substr($row['cmd_id'], 0, 5);
							echo "<tr><th>" .$order_id ."...</th><th>" .$row['buyer_id'] ."</th><th>" .$row['product'] ."</th><th>" .$row['qty'] ."</th><th>" .$row['total_cmd'] ."</th></tr>";
						}

					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
</body>
</html>