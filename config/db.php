<?php
$host = 'localhost';
$dbname = 'sakuragiTS_db';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
