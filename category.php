<?php
  require('connect.php');
  require('admin.php');  

  session_start();

  $sorted_category_string = "id DESC";  

  if (isset($_POST['sorted_category']) && isset($_SESSION['sorted_category'])) {
    switch( $_POST['sorted_category'] ){
    case 'sorted_name':
      $sorted_category_string = "name ASC";
      break;
    case 'lastest_item':
      $sorted_category_string = "id DESC";
      break;
    case 'oldest_item':
      $sorted_category_string = "id ASC";
      break;
    } 
  }
  
  $_SESSION['sorted_category'] = $sorted_category_string;

  $query = "SELECT * FROM category ORDER BY $sorted_category_string";  

  $statement = $db->prepare($query);

  $statement->execute(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Category Admin page</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <?php include('header.php') ?>
  <div>
    <a href="create_category.php ?>">
      <input type="submit" value="Publish New Category" />
    </a>
  </div>
  <div>
    <form name="sort_category" action="category.php" method="post">
      <label for="sorted_category">Sort Items:</label>
      <select name="sorted_category" id="sorted_category">
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
          <h2><a href="edit_category.php?id=<?= $row['id'] ?>"> <?= $row['name'] ?></a></h2>
          <p> 
            <span>Category name: </span>
            <span><?= $row['name'] ?></span>
          </p>
          <p>
              <span>Description: </span> 
              <span> <?= $row['description'] ?> </span>
            </p>            
          <a href="edit_category.php?id=<?= $row['id'] ?>">
            <input type="submit" value="Edit" />
          </a>
        </div>                      
      <?php endwhile ?>
    </div>
  <?php include('footer.php') ?>
  </div>
</body>
</html>