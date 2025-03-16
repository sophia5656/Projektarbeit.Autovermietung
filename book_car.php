<?php
// Start a new or resume an existing session
session_start();

// Create a new MySQLi connection to the database
$conn = new mysqli("localhost", "root", "", "car_rental");

// Check if the connection to the database failed
if ($conn->connect_error) {
    // Terminate the script and display an error message if the connection fails
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Check if the user is logged in by verifying if 'userID' is set in the session
if (!isset($_SESSION['userID'])) {
    // Terminate the script and display an error message if the user is not logged in
    die("Fehler: Sie müssen eingeloggt sein, um eine Buchung vorzunehmen.");
}

// Check if the request method is POST (i.e., form data has been submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the user ID from the session
    $userId = $_SESSION['userID'];
    // Retrieve the vehicle ID from the POST data
    $vehicleId = $_POST['vehicleId'];
    // Retrieve the start date from the POST data
    $startDate = $_POST['start_date'];
    // Retrieve the end date from the POST data
    $endDate = $_POST['end_date'];

    // Validate that the start and end dates are not empty
    if (empty($startDate) || empty($endDate)) {
        // Terminate the script and display an error message if the dates are invalid
        die("Fehler: Ungültige Daten.");
    }

    // Check for overlapping bookings to prevent double bookings
    $checkSql = "SELECT * FROM bookings 
                 WHERE VehicleID = ? 
                 AND (StartDate < ? AND EndDate > ?)";
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare($checkSql);
    // Bind the parameters to the prepared statement
    $stmt->bind_param("iss", $vehicleId, $endDate, $startDate);
    // Execute the prepared statement
    $stmt->execute();
    // Get the result of the executed statement
    $result = $stmt->get_result();

    // Check if there are any overlapping bookings
    if ($result->num_rows > 0) {
        // Set an error message in the session if an overlapping booking is found
        $_SESSION['booking_error'] = "Fehler: Dieses Fahrzeug ist für den gewählten Zeitraum bereits gebucht.";
    } else {
        // Insert the new booking into the database
        $sql = "INSERT INTO bookings (UserID, VehicleID, StartDate, EndDate) VALUES (?, ?, ?, ?)";
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare($sql);
        // Bind the parameters to the prepared statement
        $stmt->bind_param("iiss", $userId, $vehicleId, $startDate, $endDate);

        // Execute the prepared statement and check if it was successful
        if ($stmt->execute()) {
            // Set a success message in the session if the booking was successfully inserted
            $_SESSION['booking_success'] = "Erfolg: Ihre Buchung wurde gespeichert!";
        } else {
            // Set an error message in the session if the booking insertion failed
            $_SESSION['booking_error'] = "Fehler: " . $stmt->error;
        }
    }

    // Close the prepared statement
    $stmt->close();
    // Close the database connection
    $conn->close();

    // Redirect the user back to the Productoverview.php page
    header("Location: Productoverview.php");
    // Terminate the script to ensure the redirect happens immediately
    exit();
}
?>