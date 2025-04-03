<?php


include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'audio/mp3', 'video/mp4'];
    $file_type = $_FILES['file']['type'];
    if (!in_array($file_type, $allowed_types)) {
        die("Invalid file type");
    }
    
    $file_name = basename($_FILES['file']['name']);
    $file_path = "uploads/" . $file_name;
    move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
    
    $stmt = $conn->prepare("INSERT INTO files (file_name, file_path, uploaded_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $file_name, $file_path);
    $stmt->execute();
    $stmt->close();
}