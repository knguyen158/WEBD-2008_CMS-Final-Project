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
		// Prepares the Database Object with the query to edit
	 	$query = "SELECT * FROM product WHERE id = :id LIMIT 1";
	  	
	  	$statement = $db->prepare($query);

	  	$statement->bindValue(':id', $id, PDO::PARAM_INT);

	  	$statement->execute();

	  	$row = $statement->fetch();	

	  	// Retrieves all the comments of a product
	  	$comment_query = "SELECT * FROM comment WHERE product_id = :id ORDER BY date_created DESC";

    	$comment_statement = $db->prepare($comment_query);

    	$comment_statement->bindValue(':id', $id, PDO::PARAM_INT);

    	$comment_statement->execute();

    	// Retrieves the image of the product

    	$image_query = "SELECT * FROM image WHERE product_id = :id LIMIT 1";

    	$image_statement = $db->prepare($image_query);

    	$image_statement->bindValue(':id', $id, PDO::PARAM_INT);

    	$image_statement->execute();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Product: <?=strip_tags($row['name'])?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.tiny.cloud/1/bli9ucpqopmfpf70el7yrbxzomw7la2a6cwrsj7mcah9gr8c/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
	<?php include('header.php') ?>
    <div>
		<form action="process_product.php" method="post" enctype='multipart/form-data'>
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
      			 	<?php if ($image_statement -> rowCount() !== 0): ?>
	    			<?php $image_row = $image_statement -> fetch() ?>
				    	<p>Edit Product's Image</p>
				    	<div>
			            	<img src="<?=$image_row['image_path']?>" alt="<?=$image_row['image_path'] ?>">
			          	</div>		          	
		          		<div>
		      				<label for='file'>Upload an image:</label>
		         			<input type='file' name='file' id='file'>
		      			</div>
		      				<input type="hidden" name="image_id" value="<?= $image_row['id'] ?>" />      			 	
				        	<input type="submit" name="command" value="Delete Image" onclick="return confirm('Are you sure you wish to delete this image?')"/>
				    <?php else: ?>
				    	<div>
		      				<label for='file'>Upload an image:</label>
		         			<input type='file' name='file' id='file'>
		      			</div>
		        	<?php endif ?>				    
	      			<p>
	        			<input type="hidden" name="id" value="<?= $id ?>" />
	        			<input type="hidden" name="image_id" value="<?= $image_row['id'] ?>" />
			        	<input type="submit" name="command" value="Update" />
			        	<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this product?')" />
	      			</p>	      			
	    	</fieldset>
	    </form>	     
    	<fieldset>
    		<legend>Edit Comments</legend>
    		<div>
				<?php while ($comment_row = $comment_statement->fetch()): ?>
					<form action="process_comment.php" method="post">
					<p>
						<p>
        					<label for="customer_name">Customer's name</label>
        					<textarea name="customer_name" id="customer_name"><?= $comment_row['name'] ?></textarea>
      					</p>	
  						<p>
        					<label for="comment_content">Comment</label>
        					<textarea name="comment_content" id="comment_content"><?= $comment_row['content'] ?></textarea>
      					</p>
					</p>
					<p>
						<input type="hidden" name="comment_id" value="<?= $comment_row['id'] ?>" />
						<input type="hidden" name="product_id" value="<?= $comment_row['product_id'] ?>" />
		        		<input type="submit" name="command" value="Update Comment" />
		        		<input type="submit" name="command" value="Delete Comment" onclick="return confirm('Are you sure you wish to delete this comment?')" />
      				</p> 
      				</form>     					
				<?php endwhile ?>
				</div>	
    	</fieldset>		
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
