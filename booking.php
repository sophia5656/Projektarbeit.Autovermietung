<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "car_rental";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login if session is missing
    exit();
}

$UserID = $_SESSION['userID']; // Use UserID directly


// Fetch total number of bookings
$countSql = "SELECT COUNT(*) AS total FROM bookings WHERE UserID = ?";
$countStmt = $conn->prepare($countSql);
$countStmt->bind_param("i", $UserID);
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalBookings = $countResult->fetch_assoc()['total'];
$countStmt->close();



// Pagination setup
$limit = 5; // Number of bookings per page
$totalPages = max(1, ceil($totalBookings / $limit));
$page = isset($_GET['page']) ? max(1, min(intval($_GET['page']), $totalPages)) : 1;
$offset = ($page - 1) * $limit;

// Fetch user's bookings with pagination
$sql = "SELECT b.StartDate, b.EndDate, l.City, m.Manufacturer, m.ModelName
        FROM bookings b
        JOIN Vehicles v ON b.VehicleID = v.VehicleID
        JOIN VehicleModels m ON v.ModelID = m.ModelID
        JOIN Locations l ON v.LocationID = l.LocationID
        WHERE b.UserID = ? 
        ORDER BY b.StartDate DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $UserID, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$bookings = []; // Initialize empty array

// Fetch results into an array
while ($row = $result->fetch_assoc()) {
    $bookings[] = [
        'car' => $row['Manufacturer'] . ' ' . $row['ModelName'],
        'date' => $row['StartDate'] . " - " . $row['EndDate'],
        'location' => $row['City']
    ];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Buchungen</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f8f8f8; text-align: center; padding: 20px; }
        .booking-container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 90%; max-width: 800px; margin: 30px auto; }
        h1 { color: rgb(255, 0, 43); margin-bottom: 20px; }
        .booking-list { list-style: none; padding: 0; }
        .booking-item { background: #fff; padding: 15px; margin: 10px 0; border-left: 5px solid rgb(255, 0, 43); border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); text-align: left; }
        .no-bookings { color: #777; font-size: 1.2rem; margin-top: 20px; }
        .pagination { margin-top: 20px; }
        .pagination a { display: inline-block; padding: 8px 12px; margin: 0 5px; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #333; background: #fff; }
        .pagination a:hover { background: rgb(255, 0, 43); color: #fff; }
        .pagination .current { font-weight: bold; padding: 8px 12px; background: rgb(255, 0, 43); color: white; border-radius: 5px; }
        @media (max-width: 768px) { .booking-container { width: 95%; padding: 30px; } }
    </style>
</head>
<body>
    <div class="booking-container">
        <h1>Meine Buchungen</h1>
        <?php if (!empty($bookings)) { ?>
            <ul class='booking-list'>
                <?php foreach ($bookings as $booking) { ?>
                    <li class='booking-item'><strong><?= htmlspecialchars($booking['car']) ?></strong> - <?= htmlspecialchars($booking['date']) ?> in <?= htmlspecialchars($booking['location']) ?></li>
                <?php } ?>
            </ul>
            <div class="pagination">
                <?php if ($page > 1) { ?>
                    <a href="?page=<?= $page - 1 ?>">&laquo; Zurück</a>
                <?php } ?>
                <span class="current">Seite <?= $page ?> von <?= $totalPages ?></span>
                <?php if ($page < $totalPages) { ?>
                    <a href="?page=<?= $page + 1 ?>">Weiter &raquo;</a>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class='no-bookings'>Sie haben noch keine Buchungen getätigt.</p>
        <?php } ?>
    </div>
</body>
</html>
