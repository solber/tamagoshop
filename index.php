<?php include('required/header.php'); ?>
	<div class="container">
		<?php require_once 'required/flash.php'; ?>
		<?php include('required/filters.php'); ?>
		<ul class="products">
		    <?php 
		    if (empty($_GET['cat']))
		    	require_once 'required/product_list.php'; 
		    else
		    	require_once 'required/product_list_specific.php';
		    ?>
		</ul>
	</div>
</body>
</html>