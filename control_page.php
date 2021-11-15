<?php
  require('connect.php');
  require('admin.php');  

  session_start();

  $sorted_string = "date_created DESC";  

  if (isset($_POST['sorted_item']) && isset($_SESSION['sorted_string'])) {
    switch( $_POST['sorted_item'] ){
    case 'sorted_name':
      $sorted_string = "name ASC";
      break;
    case 'lastest_item':
      $sorted_string = "date_created DESC";
      break;
    case 'oldest_item':
      $sorted_string = "date_created ASC";
      break;
    } 
  }
  
  $_SESSION['sorted_string'] = $sorted_string;

  $query = "SELECT * FROM product ORDER BY $sorted_string";  

  $statement = $db->prepare($query);

  $statement->execute(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin page</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <?php include('header.php') ?>
  <div>
    <a href="create.php ?>">
      <input type="submit" value="Publish New Product" />
    </a>
  </div>
  <div>
    <a href="category.php ?>">
      <input type="submit" value="Category Admin Page" />
    </a>
  </div>
  <div>
    <form name="sort" action="control_page.php" method="post">
      <label for="sorted_item">Sort Items:</label>
      <select name="sorted_item" id="sorted_item">
        <option value="sorted_name">By Name</option></a>
        <option value="latest_item">Latest Items</option>
        <option value="oldest_item">Oldest Items</option>
      </select>
      <input type="submit" value="Sort" />
    </form>        
  </div>  
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
          <a href="edit.php?id=<?= $row['id'] ?>">
            <input type="submit" value="Edit" />
          </a>
        </div>                      
      <?php endwhile ?>
    </div>
  <?php include('footer.php') ?>
  </div>
</body>
</html>