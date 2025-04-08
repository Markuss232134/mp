<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $allowed_types = [
        'image/jpeg', 'image/png',
        'application/pdf', 'application/msword',
        'application/vnd.ms-excel',
        'audio/mp3', 'video/mp4'
    ];

    $file = $_FILES['file'];
    $file_type = $file['type'];

    if (!in_array($file_type, $allowed_types)) {
        die("Invalid file type.");
    }

    $upload_dir = __DIR__ . '/uploads/';
    

    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            die("Failed to create upload directory.");
        }
    }

    $file_name = basename($file['name']);
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        $relative_path = 'uploads/' . $file_name;

        $stmt = $conn->prepare("INSERT INTO files (file_name, file_path, uploaded_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $file_name, $relative_path);
        $stmt->execute();
        $stmt->close();

        echo "File uploaded and saved successfully.";

        echo "<script>
                setTimeout(function() {
                    window.location.href = '/frontend/index.php'; 
                }, 4000); // Redirect after 4 seconds
              </script>";
    } else {
        echo "Failed to move uploaded file.";
    }
} else {
    echo "No file uploaded.";
}
?>
