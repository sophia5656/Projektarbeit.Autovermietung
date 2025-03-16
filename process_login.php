<?php
// Ensure that only one session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ob_start(); // Enable output buffering to prevent header issues

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "car_rental");

// Check if the database connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Use the correct column names from the database: 'UserID', 'Name', 'Password'
    $stmt = $conn->prepare("SELECT UserID, Name, Password FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid, $name, $db_password);
        $stmt->fetch();

        // No `password_verify()` since passwords are stored in plaintext
        if ($password === $db_password) {
            // Set session variables
            $_SESSION["userID"] = $userid;
            $_SESSION["username"] = $name;

            // Redirect to the homepage
            header("Location: index.php");
            exit;
        } else {
            // Incorrect password → Redirect back to login page with error message
            header("Location: login.php?error=wrongpassword");
            exit;
        }
    } else {
        // User not found → Redirect back to login page with error message
        header("Location: login.php?error=usernotfound");
        exit;
    }
}

$conn->close();
ob_end_flush();
?>