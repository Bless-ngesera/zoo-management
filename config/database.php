<?php
// Database configuration
define('DSN', 'mysql:host=localhost;dbname=zoo_management;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', 'mysql061004!');

// Initialize PDO
try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Error: Could not connect to the database. ' . $e->getMessage());
}
?>