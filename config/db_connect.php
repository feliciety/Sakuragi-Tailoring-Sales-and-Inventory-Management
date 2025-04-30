<?php

$host = 'localhost';
$dbname = 'sakuragi_db';
$user = 'root';  
$pass = '';     

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Error reporting
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
