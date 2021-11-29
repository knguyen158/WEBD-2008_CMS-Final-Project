<?php
    /*
    This is the process post page: create new product, edit product, and delete product
    */

    require('connect.php');
    require 'ImageResize.php';
    require 'ImageResizeException.php';
    use \Gumlet\ImageResize;

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
        	//$sanitized_product = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $insert_query = "INSERT INTO product (category_id, name, description, price) VALUES (:category, :name, :description, :price)";
            $insert_statement = $db->prepare($insert_query);

            $insert_statement->bindValue(':category', $_POST['product_category']);
            $insert_statement->bindValue(':name', $_POST['product_name']);
            $insert_statement->bindValue(':description', $_POST['product_description']);
            $insert_statement->bindValue(':price', $_POST['product_price']);

            $insert_statement->execute();

            // select the inserted product
            $selected_product_query = "SELECT * FROM product ORDER BY id DESC LIMIT 1";

            $select_statement = $db->prepare($selected_product_query);

            $select_statement->execute();
            $select_row = $select_statement -> fetch();

            function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
                $current_folder = dirname(__FILE__);

                $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

                return join(DIRECTORY_SEPARATOR, $path_segments);
            }   

            function file_is_image($temporary_path, $new_path) {
                $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
                $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
                
                $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
                $actual_mime_type        = mime_content_type($temporary_path);
                
                $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
                $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
                
                return $file_extension_is_valid && $mime_type_is_valid;
            }

            $file_upload_detected = isset($_FILES['file']) && ($_FILES['file']['error'] === 0);
            $upload_error_detected = isset($_FILES['file']) && ($_FILES['file']['error'] > 0);

            if ($file_upload_detected) { 
                $filename             = strtolower($_FILES['file']['name']);
                $temporary_file_path  = $_FILES['file']['tmp_name'];
                $new_file_path        = file_upload_path($filename);
                if (file_is_image($temporary_file_path, $new_file_path)) {
                    move_uploaded_file($temporary_file_path, $new_file_path);           
                
                    $file_extension = pathinfo($new_file_path, PATHINFO_EXTENSION);

                    // resize to 400 width and height for medium image
                    $upload_image = new ImageResize($new_file_path);
                    $upload_image->resizeToBestFit(500, 300);
                    $upload_image_name = basename($new_file_path, '.'.$file_extension) . '_resized.' . $file_extension;
                    $upload_image->save('.\uploads\\'.$upload_image_name);

                    
                    // insert the image path to the table
                    $insert_image_query = "INSERT INTO image (product_id, image_path) VALUES (:product_id, :image_path)";
                    $insert_image_statement = $db->prepare($insert_image_query);

                    $insert_image_statement->bindValue(':product_id', $select_row['id'], PDO::PARAM_INT);
                    $insert_image_statement->bindValue(':image_path', '.\uploads\\'.$upload_image_name);

                    $insert_image_statement->execute();
                }
            }

            header("Location: control_page.php");
            die();
        }
        // When admin wants to edit a product
        else if ($_POST['command'] === "Update") {
            if ($_POST && isset($_POST['product_name']) && isset($_POST['product_description']) && isset($_POST['product_price']) && isset($_POST['id'])) {
                //$sanitized_product = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $sanitized_id   = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                    
                $update_query     = "UPDATE product SET category_id = :category, name = :name, description = :description, price = :price WHERE id = :id";
                $update_statement = $db->prepare($update_query);

                $update_statement->bindValue(':category', $_POST['product_category']);       
                $update_statement->bindValue(':name', $_POST['product_name']);
                $update_statement->bindValue(':description', $_POST['product_description']);
                $update_statement->bindValue(':price', $_POST['product_price']);
                $update_statement->bindValue(':id', $sanitized_id, PDO::PARAM_INT);
                    
                $update_statement->execute();

                function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
                    $current_folder = dirname(__FILE__);

                    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

                    return join(DIRECTORY_SEPARATOR, $path_segments);
                }  

                function file_is_image($temporary_path, $new_path) {
                    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
                    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
                    
                    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
                    $actual_mime_type        = mime_content_type($temporary_path);
                    
                    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
                    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
                    
                    return $file_extension_is_valid && $mime_type_is_valid;
                }

                $file_upload_detected = isset($_FILES['file']) && ($_FILES['file']['error'] === 0);
                $upload_error_detected = isset($_FILES['file']) && ($_FILES['file']['error'] > 0);

                if ($file_upload_detected) { 
                    $filename             = strtolower($_FILES['file']['name']);
                    $temporary_file_path  = $_FILES['file']['tmp_name'];
                    $new_file_path        = file_upload_path($filename);
                    if (file_is_image($temporary_file_path, $new_file_path)) {
                        move_uploaded_file($temporary_file_path, $new_file_path);           
                    
                        $file_extension = pathinfo($new_file_path, PATHINFO_EXTENSION);

                        // resize to 400 width and height for medium image
                        $upload_image = new ImageResize($new_file_path);
                        $upload_image->resizeToBestFit(500, 300);
                        $upload_image_name = $sanitized_id . '_resized.' . $file_extension;
                        $upload_image->save('.\uploads\\'.$upload_image_name);                                    
                    }

                    $sanitized_img_id =  filter_input(INPUT_POST, 'image_id', FILTER_SANITIZE_NUMBER_INT);
                    $select_img_query = "SELECT * FROM image WHERE id = :image_id";

                    $select_img_statement = $db -> prepare($select_img_query);
                    $select_img_statement->bindValue(':image_id', $sanitized_img_id, PDO::PARAM_INT); 
                    $select_img_statement->execute();

                    if ($select_img_statement -> rowCount() === 0)
                    {                        
                        $insert_image_query = "INSERT INTO image (product_id, image_path) VALUES (:product_id, :image_path)";
                        $insert_image_statement = $db->prepare($insert_image_query);

                        $insert_image_statement->bindValue(':product_id', $sanitized_id, PDO::PARAM_INT);
                        $insert_image_statement->bindValue(':image_path', '.\uploads\\'.$upload_image_name);

                        $insert_image_statement->execute(); 
                    }
                    else {
                        $update_image_query     = "UPDATE image SET image_path = :image_path WHERE id = :id";
                        $update_image_statement = $db->prepare($update_image_query);

                        $update_image_statement->bindValue(':image_path', '.\uploads\\'.$upload_image_name);
                        $update_image_statement->bindValue(':id', $sanitized_img_id, PDO::PARAM_INT);
                        
                        $update_image_statement->execute();
                    }                     
                }                

                header("Location: control_page.php");
                die();                
            } 
        }

        // When admin wants to delete an image
        if ($_POST['command'] === "Delete Image") {            
            if ($_POST && isset($_POST['image_id'])) {
                $sanitized_img_id = filter_input(INPUT_POST, 'image_id', FILTER_SANITIZE_NUMBER_INT);
                $sanitized_id   = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

                $delete_image_query = "DELETE FROM image WHERE id = :image_id LIMIT 1";
                $delete_image_statement = $db -> prepare($delete_image_query);

                // if ($delete_image_statement -> rowCount() !== 0)
                // {
                    $delete_image_statement->bindValue(':image_id', $sanitized_img_id, PDO::PARAM_INT);
                    $delete_image_statement->execute();
                // }

                header("Location: edit.php?id=".$sanitized_id);
                die();
            }  
        }

        // When admin wants to delete a product
        if ($_POST['command'] === "Delete") {            
            if ($_POST && isset($_POST['id'])) {
            $sanitized_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $delete_image_query = "DELETE FROM image WHERE product_id = :id LIMIT 1";
            $delete_image_statement = $db -> prepare($delete_image_query);

            $delete_image_statement->bindValue(':id', $sanitized_id, PDO::PARAM_INT);
            $delete_image_statement->execute();

            $delete_comment_query = "DELETE FROM comment WHERE product_id = :id";
            $delete_comment_statement = $db -> prepare($delete_comment_query);

            $delete_comment_statement->bindValue(':id', $sanitized_id, PDO::PARAM_INT);
            $delete_comment_statement->execute();

            $delete_query = "DELETE FROM product WHERE id = :id LIMIT 1";
            $delete_statement = $db->prepare($delete_query);

            $delete_statement->bindValue(':id', $sanitized_id, PDO::PARAM_INT);

            $delete_statement->execute();

            header("Location: control_page.php");
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