<?php
    /*
    This is the process post page: create new product, edit product, and delete product
    */
    require('admin.php');
    require('connect.php');

    $errors = [];

    // Title and content validation
    if (empty($_POST['category_name']) && $_POST['category_name']!=0) {
        array_push($errors, "Please enter the category name.");
    }
    elseif (empty($_POST['category_description']) && $_POST['category_description']!=0) {
        array_push($errors, "Please enter the category description.");
    }

    if(empty($errors)) {
        // When admin chooses create a new product
        if ($_POST['command'] === "Publish Category") {
        	$sanitized_category = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $insert_query = "INSERT INTO category (name, description) VALUES (:name, :description)";
            $insert_statement = $db->prepare($insert_query);

            $insert_statement->bindValue(':name', $sanitized_category['category_name']);
            $insert_statement->bindValue(':description', $sanitized_category['category_description']);

            $insert_statement->execute();

            header("Location: category.php");
            die();
        }
        // When admin wants to edit a product
        else if ($_POST['command'] === "Update") {
            if ($_POST && isset($_POST['category_name']) && isset($_POST['category_description']) && isset($_POST['id'])) {
                $sanitized_category = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $sanitized_id   = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                    
                $update_query     = "UPDATE category SET name = :name, description = :description WHERE id = :id";
                $update_statement = $db->prepare($update_query);

                $update_statement->bindValue(':name', $sanitized_category['category_name']);
                $update_statement->bindValue(':description', $sanitized_category['category_description']);
                $update_statement->bindValue(':id', $sanitized_id, PDO::PARAM_INT);
                    
                $update_statement->execute();

                header("Location: category.php");
                die();
            } 
        }        
    }

    // When admin wants to delete a product
    if ($_POST['command'] === "Delete") {            
            if ($_POST && isset($_POST['id'])) {
            $sanitized_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $delete_query = "DELETE FROM category WHERE id = :id LIMIT 1";
            $delete_statement = $db->prepare($delete_query);

            $delete_statement->bindValue(':id', $sanitized_id, PDO::PARAM_INT);

            $delete_statement->execute();

            header("Location: category.php");
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