<?php
    define('DB_DSN','mysql:host=localhost;dbname=sfinalproject');
    define('DB_USER','localhost');
    define('DB_PASS','Password01');

    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>