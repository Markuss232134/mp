<?php

require 'config.php';

$result = $conn->query("SELECT id, file_name, file_path, uploaded_at FROM files ORDER BY uploaded_at DESC");

echo "<h2>Uploaded Files</h2>";

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $file_name = htmlspecialchars($row['file_name']);
    $file_path = htmlspecialchars($row['file_path']);
    $uploaded_at = $row['uploaded_at'];

    $ext = pathinfo($file_name, PATHINFO_EXTENSION);

    echo "<div style='margin-bottom: 20px;'>";
    echo "<strong>$file_name</strong><br>";
    echo "<a href='download.php?id=$id'>Download</a><br>"; 
    echo "<em>Uploaded at: $uploaded_at</em><br>";

    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
        echo "<img src='$file_path' style='max-width: 300px; display:block; margin-top:10px;'><br>";
    } elseif ($ext === 'pdf') {
        echo "<a href='$file_path' target='_blank'>View PDF</a><br>";
    } elseif (in_array($ext, ['mp3'])) {
        echo "<audio controls><source src='$file_path' type='audio/mp3'>Your browser does not support the audio tag.</audio><br>";
    } elseif ($ext === 'mp4') {
        echo "<video controls width='320'><source src='$file_path' type='video/mp4'>Your browser does not support the video tag.</video><br>";
    }

    echo "</div>";
}?>
<link rel="stylesheet" type="text/css" href="/frontend/style.css">
<form action="/frontend/index.php" method="GET">
            <button type="submit">Home</button>

