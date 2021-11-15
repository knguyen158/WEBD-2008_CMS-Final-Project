<?php
	/*
  	This is the edit page
  	*/
  	
	require('admin.php');
	require('connect.php');

	$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

	$category_query = "SELECT * FROM category ORDER BY name ASC";

  	$category_statement = $db->prepare($category_query);

  	$category_statement->execute();

	if ($id == false) {
		header("Location: product.php");
	}
	else {
		// Prepare the Database Object with the query to edit
	 	$query = "SELECT * FROM product WHERE id = :id LIMIT 1";
	  	
	  	$statement = $db->prepare($query);

	  	$statement->bindValue(':id', $id, PDO::PARAM_INT);

	  	$statement->execute();

	  	$row = $statement->fetch();	
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Product <?= $row['name'] ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<?php include('header.php') ?>
    <div>
		<form action="process_product.php" method="post">
			<fieldset>
	      		<legend>Edit Product</legend>
	      			<p>						
						<label for="product_category">Category</label>
						<select name="product_category" id="product_category">
							<?php while ($category_row = $category_statement->fetch()): ?>
							<option value="<?= $category_row['id'] ?>"><?= $category_row['name'] ?></option>
							<?php endwhile ?>
						</select>							
	      			</p>
	      			<p>
	        			<label for="product_name">Product name</label>
	        			<textarea name="product_name" id="product_name"><?= $row['name']?></textarea>
	      			</p>
	      			<p>
	        			<label for="product_description">Description</label>
	        			<textarea name="product_description" id="product_description"><?= $row['description']?></textarea>
	      			</p>
	      			<p>
	        			<label for="product_price">Price</label>
	        			<input type="number" step="any" name="product_price" id="product_price" value="<?= $row['price']?>"></input>
	      			</p>
	      			<p>
	        			<input type="hidden" name="id" value="<?= $id ?>" />
			        	<input type="submit" name="command" value="Update" />
			        	<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this product?')" />
	      			</p>
	    	</fieldset>	    	
		</form>
    </div>
    <?php include('footer.php') ?>
</body>
</html>
