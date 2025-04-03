<?php

include 'config.php';
include 'Validation.php';

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

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, surname, email, password, phone, dob) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $surname, $email, $hashed_password, $phone, $dob);
    $stmt->execute();
    $stmt->close();
}
?>