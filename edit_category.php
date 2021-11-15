<?php
	/*
  	This is the edit page
  	*/
  	
	require('admin.php');
	require('connect.php');

	$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

	if ($id == false) {
		header("Location: product.php");
	}
	else {
		// Prepare the Database Object with the query to edit
	 	$query = "SELECT * FROM category WHERE id = :id LIMIT 1";
	  	
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
    <title>Edit Category <?= $row['name'] ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<?php include('header.php') ?>
    <div>
		<form action="process_category.php" method="post">
			<fieldset>
	      		<legend>Edit Category</legend>
	      			<p>
	        			<label for="category_name">Category name</label>
	        			<textarea name="category_name" id="category_name"><?= $row['name']?></textarea>
	      			</p>
	      			<p>
	        			<label for="category_description">Description</label>
	        			<textarea name="category_description" id="category_description"><?= $row['description']?></textarea>
	      			</p>
	      			<p>
	        			<input type="hidden" name="id" value="<?= $id ?>" />
			        	<input type="submit" name="command" value="Update" />
			        	<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this category?')" />
	      			</p>
	    	</fieldset>	    	
		</form>
    </div>
    <?php include('footer.php') ?>
</body>
</html>
