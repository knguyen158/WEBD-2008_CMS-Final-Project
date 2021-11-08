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
		<div id="all_blogs">
			<form action="process_post.php" method="post">
		    	<fieldset>
		      		<legend>New Product</legend>
		      			<p>
		        			<label for="category">Category</label>
		        			<select name="category" id="category">
								<option value="tops">Tops</option>
								<option value="skirts">Skirts</option>
								<option value="pants">Pants</option>
								<option value="underwear">Underwears</option>
								<option value="dresses">Dresses</option>
							</select>
		      			</p>
		      			<p>
		        			<label for="productname">Product Name</label>
		        			<textarea name="productname" id="productname"></textarea>
		      			</p>
		      			<p>
		        			<label for="productprice">Product Price</label>
		        			<textarea name="productprice" id="productprice"></textarea>
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
