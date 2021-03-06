<?php
	/*
  	This is the new product publishing page
  	*/

	require('admin.php');
	require('connect.php');
	
	// Retrieves rows from database
	$query = "SELECT * FROM category ORDER BY name ASC";

	$statement = $db->prepare($query);

	$statement->execute();	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Publish a new product</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.tiny.cloud/1/bli9ucpqopmfpf70el7yrbxzomw7la2a6cwrsj7mcah9gr8c/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
	<?php include('header.php') ?>
    <div>
		<div>
			<form action="process_product.php" method="post" enctype='multipart/form-data'>
		    	<fieldset>
		      		<legend>Publish New Product</legend>
		      			<p>						
						<label for="product_category">Category</label>
						<select name="product_category" id="product_category">
							<?php while ($row = $statement->fetch()): ?>
							<option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
							<?php endwhile ?>
						</select>							
	      			</p>
	      			<p>
	        			<label for="product_name">Product name</label>
	        			<textarea name="product_name" id="product_name"></textarea>
	      			</p>
	      			<p>
	        			<label for="product_description">Description</label>
	        			<textarea name="product_description" id="product_description"></textarea>
	      			</p>
	      			<p>
	        			<label for="product_price">Price</label>
	        			<input type="number" step="any" name="product_price" id="product_price">
	      			</p>
	      			<div>
	      				<label for='file'>Filename:</label>
	         			<input type='file' name='file' id='file'>
	      			</div>	      			
	      			<p>
	        			<input type="submit" name="command" value="Publish Product" />
	      			</p>
		    	</fieldset>
			</form>
		</div>
    <?php include('footer.php') ?>
    <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Khanh Nguyen',      
      forced_root_block : false,
    });
  </script>
</body>
</html>
