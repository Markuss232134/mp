<?php


function validateUserData($name, $surname, $email, $password, $phone, $dob) {
    if (!preg_match("/^[a-zA-ZāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ]+$/u", $name) || !preg_match("/^[a-zA-ZāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ]+$/u", $surname)) {
        return "Invalid name or surname";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@[a-zA-Z]+\.(com|lv|org|net)$/", $email)) {
        return "Invalid email format";
    }
    if (strlen($password) < 15 || !preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{15,}$/", $password)) {
        return "Password must be at least 15 characters long and include uppercase, lowercase, a number, and a special character";
    }
    if (!preg_match("/^\d{8}$/", $phone)) {
        return "Invalid phone number";
    }
    if (strtotime($dob) > time()) {
        return "Invalid date of birth";
    }
    return true;
}
?>