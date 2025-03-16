<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if a car_id is provided
if (!isset($_GET['car_id'])) {
    die("Fehler: Kein Fahrzeug ausgewählt.");
}

$car_id = $_GET['car_id'];

// Database connection
$conn = new mysqli("localhost", "root", "", "car_rental");
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$booking_date = date("Y-m-d");
$dt = new DateTime($booking_date);  // creates new date-object 
$dt->modify("+3 days");  // adds 3 days
$return_date = $dt->format("Y-m-d");  // Formats the new date correctly
// Get car price
$stmt = $conn->prepare("SELECT price_per_day FROM cars WHERE id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    die("Fehler: Fahrzeug nicht gefunden.");
}

$price = $car['price_per_day'] * 3; // Price for 3 days

// Save booking
$stmt = $conn->prepare("INSERT INTO bookings (user_id, car_id, booking_date, return_date, price) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iissd", $user_id, $car_id, $booking_date, $return_date, $price);

if ($stmt->execute()) {
    // Redirect to booking_success.php
    header("Location: process_success.php");
    exit;
} else {
    die("Fehler bei der Buchung.");
}

$conn->close();
?>