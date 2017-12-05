<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=cb_database;", 'user', 'J4UEQwk2');
} catch (PDOException $e) {
    die("Error occurred: " . $e->getMessage());
}

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

header('Content-Type: text/html; charset=UTF-8');

?>
