<?php
  /*
  This is the index page
  */
  
  require('connect.php');

  // Retrieves rows from database
  $query = "SELECT * FROM product ORDER BY date_created DESC LIMIT 9";

  $statement = $db->prepare($query);

  $statement->execute();
?>
