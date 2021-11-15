<?php
  /*
  This is the detail product page
  */
  
  require('connect.php');

  // Retrieves rows from database
  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

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

    // $category_name = "";

    $category_query = "SELECT * FROM category WHERE id = :id LIMIT 1";

    $category_statement = $db->prepare($category_query);

    $category_statement->bindValue(':id', $row['category_id'], PDO::PARAM_INT);

    $category_statement->execute();

    $category_row = $category_statement->fetch();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tops</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <?php include('header.php') ?>
  <div>
    <div>
        <div>
          <h2><a href="product_detail.php?id=<?= $row['id'] ?>"> <?= $row['name'] ?></a></h2>
          <p> 
            <span>Product name: </span>
            <span><?= $row['name'] ?></span>
          </p>
          <p> 
            <span>Category: </span>
            <span><?= $category_row['name'] ?></span>
          </p>
          <p> 
            <span>Description: </span>
            <span><?= $row['description'] ?></span>
          </p>
          <p> 
            <span>Price: </span>
            <span>$<?= $row['price'] ?></span>
          </p>
        </div>                
    </div>
  <?php include('footer.php') ?>
  </div>
</body>
</html>