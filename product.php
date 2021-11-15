<?php
  /*
  This is the index page
  */
  
  require('connect.php');

  // Retrieves rows from database
  $query = "SELECT * FROM product ORDER BY date_created DESC";

  $statement = $db->prepare($query);

  $statement->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>All Products</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <?php include('header.php') ?>
  <div>
    <div>
      <?php while ($row = $statement->fetch()): ?>
        <div>
          <h2><a href="product_detail.php?id=<?= $row['id'] ?>"> <?= $row['name'] ?></a></h2>
          <p> 
            <span>Product name: </span>
            <span><?= $row['name'] ?></span>
          </p>
          <?php $category_query = "SELECT * FROM category WHERE id = :id" ?>

          <?php $category_statement = $db->prepare($category_query) ?>
          <?php $category_statement->bindValue(':id', $row['category_id'], PDO::PARAM_INT) ?>
          <?php $category_statement->execute() ?>
          <?php $category_row = $category_statement->fetch() ?>
          <p>
            <span>Category: </span>
            <span><?= $category_row['name'] ?></span> 
          </p>
          <?php if (strlen($row['description']) > 151): ?>
            <p>
              <span>Product description: </span>
              <span><?= substr($row['description'], 0, 150) ?>
              <a href="product_detail.php?id=<?= $row['id'] ?>">Read more</a>
              </span>
            </p>
          <?php else: ?>
            <p>
              <span>Description: </span> 
              <span> <?= $row['description'] ?> </span>
            </p>            
          <?php endif ?>
          <p>
            <span>Price: </span>
            <span>$<?= $row['price'] ?> </span> 
          </p>
        </div>                
      <?php endwhile ?>
    </div>
  <?php include('footer.php') ?>
  </div>
</body>
</html>