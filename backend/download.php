<?php
require 'config.php';

// Check if the 'id' parameter is set in the URL
if (!isset($_GET['id'])) {
    die("No file ID specified.");
}

// Sanitize the file ID input
$file_id = intval($_GET['id']);

// Prepare the SQL statement to get file details (name and path)
$stmt = $conn->prepare("SELECT file_name, file_path FROM files WHERE id = ?");
$stmt->bind_param("i", $file_id);
$stmt->execute();
$stmt->store_result();

// If no file found with the given ID, show an error
if ($stmt->num_rows === 0) {
    die("File not found.");
}

$stmt->bind_result($file_name, $file_path);
$stmt->fetch();
$stmt->close();

// Check if the file exists on the server
if (!file_exists($file_path)) {
    die("File does not exist on the server.");
}

// Set headers to download the file
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
header('Content-Length: ' . filesize($file_path));

// Output the file content to the browser
readfile($file_path);
exit;
