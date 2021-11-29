<?php
    /*
    This is the process post page: post new comment, edit comment, and delete comment
    */

    require('connect.php');
    session_start();

    $errors = [];

    // Title and content validation
    if (empty($_POST['customer_name']) && $_POST['customer_name']!=0) {
        array_push($errors, "Please enter your name to commend.");
    }
    elseif (empty($_POST['comment_content']) && $_POST['comment_content']!=0) {
        array_push($errors, "Please enter your commend into the box.");
    }

    if(empty($errors)) {
        // When admin chooses create a new product
        if ($_POST['command'] === "Post Comment") {
        	$sanitized_comment = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $insert_query = "INSERT INTO comment (product_id, name, content) VALUES (:product_id, :customer_name, :comment_content)";
            $insert_statement = $db->prepare($insert_query);

            $insert_statement->bindValue(':product_id', $_SESSION['product_id'], PDO::PARAM_INT);
            $insert_statement->bindValue(':customer_name', $sanitized_comment['customer_name']);
            $insert_statement->bindValue(':comment_content', $sanitized_comment['comment_content']);

            $insert_statement->execute();

            header("Location: product_detail.php?id=".$_POST['product_id']);
            die();
        }
        // When admin wants to edit a comment
        else if ($_POST['command'] === "Update Comment") {
            
            if ($_POST && isset($_POST['customer_name']) && isset($_POST['comment_content']) && isset($_POST['comment_id'])) {

                //$sanitized_comment = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $sanitized_comment_id   = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
                    
                $update_query     = "UPDATE comment SET name = :customer_name, content = :comment_content WHERE id = :comment_id";
                $update_statement = $db->prepare($update_query);
                
                $update_statement->bindValue(':customer_name', $_POST['customer_name']);
                $update_statement->bindValue(':comment_content', $_POST['comment_content']);
                $update_statement->bindValue(':comment_id', $sanitized_comment_id, PDO::PARAM_INT);
                    
                $update_statement->execute();

                header("Location: edit.php?id=".$_POST['product_id']);
                die();
            } 
        }

        if ($_POST['command'] === "Delete Comment") {            
            if ($_POST && isset($_POST['comment_id'])) {
                $sanitized_comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);

                $delete_query = "DELETE FROM comment WHERE id = :id LIMIT 1";
                $delete_statement = $db->prepare($delete_query);

                $delete_statement->bindValue(':id',  $sanitized_comment_id, PDO::PARAM_INT);

                $delete_statement->execute();

                header("Location: edit.php?id=".$_POST['product_id']);
                die();
            }  
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