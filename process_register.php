<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to the database
$conn = new mysqli("localhost", "root", "", "car_rental");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: register.php?error=password_mismatch");
        exit;
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        header("Location: register.php?error=email_exists");
        exit;
    }

    // Insert user into database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);
    $stmt->execute() ? header("Location: login.php?register=success") : header("Location: register.php?error=registration_failed");
}

$conn->close();
?>