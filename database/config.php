<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "sakuragi_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($conn) || !$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
