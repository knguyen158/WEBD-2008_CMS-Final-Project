<?php
  /*
  This is the detail product page
  */
  
  require('connect.php');
  session_start();

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

    // Retrieves category type

    $category_query = "SELECT * FROM category WHERE id = :id LIMIT 1";

    $category_statement = $db->prepare($category_query);

    $category_statement->bindValue(':id', $row['category_id'], PDO::PARAM_INT);

    $category_statement->execute();

    $category_row = $category_statement->fetch();

    // Retrieves all comments for this product
    $comment_query = "SELECT * FROM comment WHERE product_id = :id ORDER BY date_created DESC";

    $comment_statement = $db->prepare($comment_query);

    $comment_statement->bindValue(':id', $id, PDO::PARAM_INT);

    $comment_statement->execute();

    // Retrieves the image if there is one
    $image_query = "SELECT * FROM image WHERE product_id = :id LIMIT 1";

    $image_statement = $db->prepare($image_query);

    $image_statement->bindValue(':id', $id, PDO::PARAM_INT);

    $image_statement->execute();
    }

  $_SESSION['product_id'] = filter_var($row['id'], FILTER_SANITIZE_NUMBER_INT);

  $req_url = 'https://v6.exchangerate-api.com/v6/19090490b3cd3d40f2b249db/latest/CAD';
  $response_json = file_get_contents($req_url);

  if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {
      // Decoding
      $response = json_decode($response_json);
      // Check for success
      if('success' === $response->result) {
        // YOUR APPLICATION CODE HERE, e.g.        
        $USD_price = round(($row['price'] * $response->conversion_rates->USD), 2);
        $EUR_price = round(($row['price'] * $response->conversion_rates->EUR), 2);
        $AUD_price = round(($row['price'] * $response->conversion_rates->AUD), 2);
        $GBP_price = round(($row['price'] * $response->conversion_rates->GBP), 2);
        $HKD_price = round(($row['price'] * $response->conversion_rates->HKD), 2);
      }
    }
    catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= strip_tags($row['name']) ?></title>
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
            <span>CA$<?= $row['price'] ?></span>
            <p>
              <label for="price_exchange">Check the price in your currency:</label>
              <select name="price_exchange" id="price_exchange">    
                <option value="<?= $USD_price ?>">US$<?= $USD_price ?></option>
                <option value="<?= $EUR_price ?>">€<?= $EUR_price ?></option>
                <option value="<?= $AUD_price ?>">AU$<?= $AUD_price ?></option>
                <option value="<?= $GBP_price ?>">£<?= $GBP_price ?></option>
                <option value="<?= $HKD_price ?>">HK$<?= $HKD_price ?></option>
              </select> 
            </p>            
          </p>
        </div>
        <?php if($image_statement -> rowCount() !== 0): ?>
        <?php $image_row = $image_statement -> fetch() ?>
          <div>
            <img src="<?=$image_row['image_path']?>" alt="<?=$image_row['image_path'] ?>">
          </div>
        <?php endif ?>                
    </div>
    <form action="process_comment.php" name="comment_form" method="post" enctype="multipart/form-data">
      <fieldset>
          <legend>Comments</legend>
          <p class="form-group">
              <label for="customer_name">Customer's name</label>
              <input type="text" class="form-control" name="customer_name" id="customer_name">
          </p>

          <p class="form-group">
              <label>Comment</label>
              <input type="text" class="form-control" name="comment_content" id="comment_content">
          </p>

          <p class="row">
              <p class="form-group col-6">
                  <label>Enter Captcha</label>
                  <input type="text" class="form-control" name="captcha" id="captcha">
              </p>
              <p class="form-group col-6">
                  <label>Captcha Code</label>
                  <img src="captcha.php" alt="PHP Captcha">
              </p>
          </p>
          <input type="hidden" name="product_id" value="<?= $row['id'] ?>" />
          <input type="submit" name="command" value="Post Comment" class="btn btn-dark">
      </fieldset>
    </form>
      <div>
        <?php while ($comment_row = $comment_statement->fetch()): ?>
          <p>
            <h3><?= $comment_row['name'] ?></h3>
            <p><?= $comment_row['content'] ?></p>
          </p>          
        <?php endwhile ?>
      </div>
  <?php include('footer.php') ?>
  </div>
</body>
</html>