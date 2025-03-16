<?php
// Start a session to manage user data across pages
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "car_rental");

// Check if the connection to the database failed
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $modelId = $_POST['modelId']; // ID of the selected car model
    $city = $_POST['city']; // Selected city for pickup
    $pickup = $_POST['pickup']; // Pickup date
    $return = $_POST['return']; // Return date

    // SQL query to select a random available car from the specified model and city
    $sql = "SELECT v.VehicleID, m.Manufacturer, m.ModelName, m.ImagePath, l.City, m.VehicleType, 
                   m.SeatCount, m.Doors, m.Transmission, m.GPS, m.ClimateControl, m.PricePerDay
            FROM Vehicles v
            JOIN VehicleModels m ON v.ModelID = m.ModelID
            JOIN Locations l ON v.LocationID = l.LocationID
            WHERE m.ModelID = ? AND l.City = ?
            AND v.VehicleID NOT IN (
                SELECT b.VehicleID 
                FROM bookings b
                WHERE (b.StartDate <= ? AND b.EndDate >= ?)
            )
            ORDER BY RAND()
            LIMIT 1";

     // Prepare the SQL statement to prevent SQL injection
     $stmt = $conn->prepare($sql);
     // Bind the parameters to the statement
     $stmt->bind_param("isss", $modelId, $city, $return, $pickup);
     // Execute the statement
     $stmt->execute();
     // Get the result of the query
     $result = $stmt->get_result();

     // Check if a car was found
    if ($row = $result->fetch_assoc()) {
        // SQL query to count the number of available cars for the selected model and city
        $tally_sql = "SELECT COUNT(v.VehicleID) AS AvailableCount
                      FROM Vehicles v
                      JOIN VehicleModels m ON v.ModelID = m.ModelID
                      JOIN Locations l ON v.LocationID = l.LocationID
                      WHERE m.ModelID = ? AND l.City = ?
                      AND v.VehicleID NOT IN (
                          SELECT b.VehicleID 
                          FROM bookings b
                          WHERE (b.StartDate <= ? AND b.EndDate >= ?)
                      )";
        // Prepare the tally SQL statement
        $tally_stmt = $conn->prepare($tally_sql);
        // Bind the parameters to the tally statement
        $tally_stmt->bind_param("isss", $modelId, $city, $return, $pickup);
        // Execute the tally statement
        $tally_stmt->execute();
        // Get the result of the tally query
        $tally_result = $tally_stmt->get_result();
        // Fetch the count of available cars
        $tally_row = $tally_result->fetch_assoc();
        $availableCount = $tally_row['AvailableCount'];

        // Display car details in a pop-up or modal
        ?>
        <div class='details-container'>
            <!-- Display the car image -->
            <img class='car-image' src='<?= htmlspecialchars($row['ImagePath']); ?>' alt='Car Image'>
            <div class='details-text'>
                <!-- Display car manufacturer and model -->
                <strong><?= htmlspecialchars($row['Manufacturer'] . " " . $row['ModelName']); ?></strong><br>
                <!-- Display car location -->
                <span class='location'>Standort: <?= htmlspecialchars($row['City']); ?></span><br>
                <!-- Display car type -->
                Typ: <?= htmlspecialchars($row['VehicleType']); ?><br>
                <!-- Display seat count and number of doors -->
                Sitze: <?= htmlspecialchars($row['SeatCount']); ?> | Türen: <?= htmlspecialchars($row['Doors']); ?><br>
                <!-- Display transmission type -->
                Getriebe: <?= htmlspecialchars($row['Transmission']); ?><br>
                <!-- Display GPS and climate control availability -->
                GPS: <?= ($row['GPS'] ? 'Ja' : 'Nein'); ?> | Klimaanlage: <?= ($row['ClimateControl'] ? 'Ja' : 'Nein'); ?><br>
                <!-- Display price per day -->
                Preis: <strong><?= number_format($row['PricePerDay'], 2); ?> €</strong> pro Tag<br>
                <!-- Display the number of available cars -->
                Verfügbare Autos: <strong><?= $availableCount; ?></strong><br>
                <!-- Display the city again -->
                Standort: <strong><?= htmlspecialchars($row['City']); ?></strong><br>

                <?php if (!empty($pickup) && !empty($return)) { ?>
                    <!-- Display the selected pickup and return dates -->
                    <p class='selected-period'>
                        Ihr ausgewählter Zeitraum: 
                        <strong><?= date("d.m.Y", strtotime($pickup)); ?> - <?= date("d.m.Y", strtotime($return)); ?></strong>
                    </p>
                    <?php $buttonDisabled = ""; // Enable the booking button ?>
                <?php } else { ?>
                    <!-- Display an error message if dates are not selected -->
                    <p class='error-message' style='color: red; font-weight: bold;'>Bitte wählen Sie ein Start- und Enddatum!</p>
                    <?php $buttonDisabled = "disabled"; // Disable the booking button ?>
                <?php } ?>

                <?php if (isset($_SESSION['userID'])) { ?>
                    <!-- If the user is logged in, show the booking form -->
                    <form method='POST' action='book_car.php'>
                        <input type='hidden' name='vehicleId' value='<?= $row['VehicleID']; ?>'>
                        <input type='hidden' name='start_date' value='<?= $pickup; ?>'>
                        <input type='hidden' name='end_date' value='<?= $return; ?>'>
                        <button type='submit' class='book-btn' <?= $buttonDisabled; ?>>Jetzt buchen</button>
                    </form>
                <?php } else { ?>
                    <!-- If the user is not logged in, prompt them to log in -->
                    <p class='login-warning'>Bitte <a href='login.php'>loggen Sie sich ein</a>, um eine Buchung vorzunehmen.</p>
                <?php } ?>
            </div>
        </div>
        <?php
    } else {
        // Display an error message if no available car is found
        echo "<p style='color: red;'>Kein verfügbares Fahrzeug gefunden.</p>";
    }

    // Close the prepared statements and database connection
    $stmt->close();
    $tally_stmt->close();
    $conn->close();
}
?>