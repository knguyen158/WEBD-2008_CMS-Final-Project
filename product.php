<?php
  /*
  This is the index page
  */
  
  require('connect.php');

  // Retrieves rows from database (base query)
  $query = "SELECT * FROM product";

  if (isset($_GET['page'])) {
      $page = $_GET['page'];
  } else {
    $page = 1;
  }

  // Results per page
  $results_per_page = 1; 
  $page_first_result = ($page - 1) * $results_per_page; 
     

  if (isset($_GET['search_bar']) && $_GET['product_category'] === "") {
    $search_string = filter_input(INPUT_GET, 'search_bar', FILTER_SANITIZE_SPECIAL_CHARS);

    $query .= " WHERE name LIKE '%".$search_string."%'";

    $statement = $db->prepare($query);

    $statement->execute();

    $number_of_result = $statement -> rowCount();

    $number_of_page = ceil ($number_of_result / $results_per_page);

    $query .= " LIMIT $page_first_result, $results_per_page"; 

    $statement = $db->prepare($query);

    $statement->execute();
  }
  elseif (isset($_GET['search_bar']) && $_GET['product_category'] !== "") {
    $search_string = filter_input(INPUT_GET, 'search_bar', FILTER_SANITIZE_SPECIAL_CHARS);
    $category_search = $_GET['product_category'];

    $query .= " WHERE category_id = $category_search AND name LIKE '%".$search_string."%'";

    $statement = $db->prepare($query);

    $statement->execute();

    $number_of_result = $statement -> rowCount();

    $number_of_page = ceil ($number_of_result / $results_per_page);

    $query .= " LIMIT $page_first_result, $results_per_page"; 

    $statement = $db->prepare($query);

    $statement->execute();
  }
  else {
    $query .= " ORDER BY date_created DESC";

    $statement = $db->prepare($query);

    $statement->execute();

    $number_of_result = $statement -> rowCount();

    $number_of_page = ceil ($number_of_result / $results_per_page);

    $query .= " LIMIT $page_first_result, $results_per_page"; 

    $statement = $db->prepare($query);

    $statement->execute();
  }

  // $statement = $db->prepare($query);

  // $statement->execute();

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
      <?php if ($statement -> rowCount() === 0): ?>
        <p>Please try another product or category.</p>
      <?php else :?>
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
              <span>CA$<?= $row['price'] ?> </span> 
            </p>
            <?php $image_query = "SELECT * FROM image WHERE product_id = :id" ?>

            <?php $image_statement = $db->prepare($image_query) ?>
            <?php $image_statement->bindValue(':id', $row['id'], PDO::PARAM_INT) ?>
            <?php $image_statement->execute() ?>          
            <?php if ($image_statement -> rowCount() !== 0): ?>
              <?php $image_row = $image_statement->fetch() ?>
                <div>
                  <img src="<?=$image_row['image_path']?>" alt="<?=$image_row['image_path']?>">
                </div>
            <?php endif ?>
          </div>                
        <?php endwhile ?>
      <?php endif ?>
      <?php if (isset($_GET['search_bar'])): ?>
        <?php $sanitized_search_bar = filter_input(INPUT_GET, 'search_bar', FILTER_SANITIZE_SPECIAL_CHARS) ?>
        <?php $sanitized_product_category = filter_input(INPUT_GET, 'product_category', FILTER_SANITIZE_SPECIAL_CHARS) ?>
        <?php for($page = 1; $page <= $number_of_page; $page++): ?>
          <a href = "product.php?search_bar=<?=$sanitized_search_bar?>&product_category=<?=$sanitized_product_category?>&page=<?=$page?>"> <?=$page?> </a>
        <?php endfor ?>
      <?php else: ?>
        <?php for($page = 1; $page <= $number_of_page; $page++): ?>
        <a href = "product.php?page=<?=$page?>"> <?=$page?> </a>
        <?php endfor ?>
      <?php endif ?>  
    </div>
  <?php include('footer.php') ?>
  </div>
</body>
</html>