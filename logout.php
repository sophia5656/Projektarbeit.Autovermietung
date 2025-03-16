<?php
session_start(); // Start the session
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to the login page after logout
header("Location: login.php");
exit;
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        /* Basic page styles */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for the logout message */
        .logout-container {
            max-width: 400px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Heading */
        h1 {
            color: #333;
        }

        /* Paragraph styling */
        p {
            font-size: 1rem;
            color: #555;
        }

        /* Button styling */
        .logout-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color:rgb(255, 0, 43);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for the button */
        .logout-btn:hover {
            background-color:rgb(255, 0, 43);
        }
    </style>
</head>
<body>
    <!-- Logout confirmation container -->
    <div class="logout-container">
        <h1>Sie wurden abgemeldet</h1>
        <p>Sie haben sich erfolgreich abgemeldet. Klicken Sie auf den Button, um sich erneut anzumelden.</p>
        <a href="login.php" class="logout-btn">Zur Anmeldung</a>
    </div>
</body>
</html>