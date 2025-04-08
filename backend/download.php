<?php
require 'config.php';


if (!isset($_GET['id'])) {
    die("No file ID specified.");
}


$file_id = intval($_GET['id']);


$stmt = $conn->prepare("SELECT file_name, file_path FROM files WHERE id = ?");
$stmt->bind_param("i", $file_id);
$stmt->execute();
$stmt->store_result();


if ($stmt->num_rows === 0) {
    die("File not found.");
}

$stmt->bind_result($file_name, $file_path);
$stmt->fetch();
$stmt->close();

if (!file_exists($file_path)) {
    die("File does not exist on the server.");
}


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
header('Content-Length: ' . filesize($file_path));


readfile($file_path);
exit;
