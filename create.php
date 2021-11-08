<?php
	/*
  	This is the new product publishing page
  	*/

	require('admin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Publish a new product</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
	<?php include('header.php') ?>
    <div>
		<div>
			<form action="process_post.php" method="post">
		    	<fieldset>
		      		<legend>Publish New Product</legend>
		      			<p>
		        			<label for="category">Category</label>
		        			<select name="category" id="category">
								<option value="1">Tops</option>
								<option value="2">Skirts</option>
								<option value="3">Pants</option>
								<option value="4">Underwears</option>
								<option value="5">Dresses</option>
							</select>
		      			</p>
		      			<p>
		        			<label for="productname">Product Name</label>
		        			<textarea name="productname" id="productname"></textarea>
		      			</p>
		      			<p>
		        			<label for="productprice">Product Price</label>
		        			<input type="number" name="productprice" id="productprice"></input>
		      			</p>
		      			<p>
		        			<input type="submit" name="command" value="Submit Product" />
		      			</p>
		    	</fieldset>
			</form>
		</div>
    <?php include('footer.php') ?>
</body>
</html>
