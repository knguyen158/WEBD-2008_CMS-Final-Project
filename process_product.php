<?php
    /*
    This is the process post page: create new product, edit product, and delete product
    */

    require('connect.php');

    $errors = [];

    // Title and content validation
    if (empty($_POST['product_name']) && $_POST['product_name']!=0) {
        array_push($errors, "Please enter the product name.");
    }
    elseif (empty($_POST['product_price']) && $_POST['product_price']!=0) {
        array_push($errors, "Please enter the product price.");
    }
    elseif (empty($_POST['product_description']) && $_POST['product_description']!=0) {
        array_push($errors, "Please enter the product description.");
    }

    if(empty($errors)) {
        // When admin chooses create a new product
        if ($_POST['command'] === "Publish Product") {
        	$sanitized_product = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $insert_query = "INSERT INTO product (category_id, name, description, price) VALUES (:category, :name, :description, :price)";
            $insert_statement = $db->prepare($insert_query);

            $insert_statement->bindValue(':category', $sanitized_product['product_category']);
            $insert_statement->bindValue(':name', $sanitized_product['product_name']);
            $insert_statement->bindValue(':description', $sanitized_product['product_description']);
            $insert_statement->bindValue(':price', $sanitized_product['product_price']);

            $insert_statement->execute();

            header("Location: control_page.php");
            die();
        }
        // When admin wants to edit a product
        else if ($_POST['command'] === "Update") {
            if ($_POST && isset($_POST['product_name']) && isset($_POST['product_description']) && isset($_POST['product_price']) && isset($_POST['id'])) {
                $sanitized_product = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $sanitized_id   = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                    
                $update_query     = "UPDATE product SET category_id = :category, name = :name, description = :description, price = :price WHERE id = :id";
                $update_statement = $db->prepare($update_query);

                $update_statement->bindValue(':category', $sanitized_product['product_category']);       
                $update_statement->bindValue(':name', $sanitized_product['product_name']);
                $update_statement->bindValue(':description', $sanitized_product['product_description']);
                $update_statement->bindValue(':price', $sanitized_product['product_price']);
                $update_statement->bindValue(':id', $sanitized_id, PDO::PARAM_INT);
                    
                $update_statement->execute();

                header("Location: control_page.php");
                die();
            } 
        }        
    }

    // When admin wants to delete a product
    if ($_POST['command'] === "Delete") {            
            if ($_POST && isset($_POST['id'])) {
            $sanitized_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $delete_query = "DELETE FROM product WHERE id = :id LIMIT 1";
            $delete_statement = $db->prepare($delete_query);

            $delete_statement->bindValue(':id', $sanitized_id, PDO::PARAM_INT);

            $delete_statement->execute();

            header("Location: control_page.php");
            die();
            }  
        } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Error Page</title>
</head>
<body>
    <?php foreach($errors as $error): ?>
    <p><?= $error ?></p>
    <?php endforeach ?>
</body>
</html>