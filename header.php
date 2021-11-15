<?php
  /*
    This is the new product publishing page
    */

  // Retrieves rows from database
  $select_query = "SELECT * FROM category";

  $cat_statement = $db->prepare($select_query);

  $cat_statement->execute();
?>

<header>
  <div class="navbar">
    <!-- Your page navigation -->
  <a href="index.php">Home</a>
  <a href="product.php">Products</a>
  <div class="dropdown">
    <button class="dropbtn">Shop By Category 
      <i class="fa fa-caret-down"></i>
    </button>
  <div class="dropdown-content">
    <?php while ($cat_row = $cat_statement->fetch()): ?>
    <a href="selected_category.php?category_id=<?= $cat_row['id'] ?>"><?= $cat_row['name'] ?></a>
  <?php endwhile ?>
    <!-- <a href="skirts.php">Skirts</a>
    <a href="pants.php">Pants</a>
    <a href="underwear.php">Underwear</a>
    <a href="dresses.php">Dresses</a>
    <a href="accessories.php">Accessories</a> -->
  </div>
  </div>
  <a href="about_us.php">About Us</a>
</div>
</header>  
