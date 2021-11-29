<?php
  /*
    This is the new product publishing page
    */

  // Retrieves rows from database
  $select_query = "SELECT * FROM category ORDER BY name ASC";

  $cat_statement = $db->prepare($select_query);

  $cat_statement->execute();

  $cat_row = $cat_statement->fetchAll();
?>

<header>
  <div class="navbar">
  <a href="index.php">Home</a>
  <a href="product.php">Products</a>
  <div class="dropdown">
    <button class="dropbtn">Shop By Category 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <?php foreach ($cat_row as $item): ?>
      <a href="selected_category.php?category_id=<?= $item['id'] ?>"><?= $item['name'] ?></a>
      <?php endforeach ?>
    </div>
  </div>
  <a href="about_us.php">About Us</a>
</div>
<a href="login.php">Login</a>
<a href="register.php">Sign Up</a>
<form action="product.php" method="get">
  <input type="text" name="search_bar">
  <select name="product_category" id="product_category">    
    <option value="">All Products</option>
    <?php foreach ($cat_row as $item): ?>
    <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
    <?php endforeach ?>
  </select> 
</form>
</header>  
