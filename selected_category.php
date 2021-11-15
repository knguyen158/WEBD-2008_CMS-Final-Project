<?php
  /*
  This is the index page
  */
  
  require('connect.php');

  $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);

  if ($category_id == false) {
    header("Location: product.php");
  }
  else {
    // Retrieves rows from database
    $query = "SELECT * FROM product WHERE category_id = :category_id ORDER BY date_created DESC";
      
    $statement = $db->prepare($query);

    $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);

    $statement->execute();
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tops</title>
    <link rel="stylesheet" href="style.css" type="text/css">
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