<?php

require 'config.php';
require 'Validation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];

    $validation_result = validateUserData($name, $surname, $email, $password, $phone, $dob);
    if ($validation_result !== true) {
        die($validation_result);
    }

    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        die("Lietotājs ar šādu e-pasta adresi jau eksistē.");
    }
    $check_stmt->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, surname, email, password, phone, dob) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $surname, $email, $hashed_password, $phone, $dob);

    if ($stmt->execute()) {
        echo "Lietotājs veiksmīgi reģistrēts!";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '/frontend/index.php'; // Change to your registration page URL
                }, 4000); // 4000 milliseconds = 4 seconds
              </script>";
    } else {
        echo "Reģistrācija neizdevās: " . $stmt->error;
    }

    $stmt->close();
}
?>
