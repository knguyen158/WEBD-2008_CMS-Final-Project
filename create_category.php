<?php
	/*
  	This is the new category publishing page
  	*/

	require('admin.php');
	require('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Publish a category</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<?php include('header.php') ?>
    <div>
		<div>
			<form action="process_category.php" method="post">
		    	<fieldset>
		      		<legend>Publish New Category</legend>
		      		<p>
	        			<label for="category_name">Category name</label>
	        			<textarea name="category_name" id="category_name"></textarea>
	      			</p>
	      			<p>
	        			<label for="category_description">Category description</label>
	        			<textarea name="category_description" id="category_description"></textarea>
	      			</p>	      			
	      			<p>
	        			<input type="submit" name="command" value="Publish Category" />
	      			</p>
		    	</fieldset>
			</form>
		</div>
    <?php include('footer.php') ?>
</body>
</html>
