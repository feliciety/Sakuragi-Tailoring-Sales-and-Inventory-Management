<?php
require_once __DIR__ . '/../../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $allowedTypes = ['image/vnd.adobe.photoshop', 'application/zip'];

    // Validate file type
    if (!in_array($file['type'], $allowedTypes)) {
        die('Invalid file type. Only PSD and ZIP files are allowed.');
    }

    // Validate file size (e.g., max 10MB)
    if ($file['size'] > 10 * 1024 * 1024) {
        die('File size exceeds the maximum limit of 10MB.');
    }

    // Generate a unique file name and save the file
    $uploadDir = __DIR__ . '/uploads/';
    $filePath = $uploadDir . uniqid() . '-' . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        die('Failed to upload the file.');
    }

    // Insert file details into the database
    $stmt = $pdo->prepare(
        'INSERT INTO uploads (user_id, file_name, file_path, file_type, file_size) VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        1, // Replace with the actual user ID
        $file['name'],
        $filePath,
        $file['type'],
        $file['size'],
    ]);

    echo 'File uploaded successfully!';
}
?>
