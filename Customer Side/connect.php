<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=cars", "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>