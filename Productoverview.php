<?php
// Start a session to manage user data across pages
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "car_rental"; 

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $database);

// Check if the connection failed and display an error message
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize filter values from the GET request
$location = isset($_GET['location']) ? $conn->real_escape_string($_GET['location']) : '';
$manufacturer = isset($_GET['manufacturer']) ? $conn->real_escape_string($_GET['manufacturer']) : '';
$vehicleType = isset($_GET['vehicleType']) ? $conn->real_escape_string($_GET['vehicleType']) : '';
$transmission = isset($_GET['transmission']) ? $conn->real_escape_string($_GET['transmission']) : '';
$fuelType = isset($_GET['fuelType']) ? $conn->real_escape_string($_GET['fuelType']) : '';
$seats = isset($_GET['seats']) ? intval($_GET['seats']) : '';
$doors = isset($_GET['doors']) ? intval($_GET['doors']) : '';
$climate = isset($_GET['climate']) ? 1 : '';
$gps = isset($_GET['gps']) ? 1 : '';
$age = isset($_GET['age']) ? intval($_GET['age']) : '';
$drive = isset($_GET['drive']) ? $conn->real_escape_string($_GET['drive']) : '';
$price = isset($_GET['price']) ? floatval($_GET['price']) : '';
$sort = isset($_GET['sort']) ? $conn->real_escape_string($_GET['sort']) : 'PricePerDay ASC';
$pickup = isset($_GET['pickup']) ? $conn->real_escape_string($_GET['pickup']) : '';
$return = isset($_GET['return']) ? $conn->real_escape_string($_GET['return']) : '';

// Pagination: Get the current page number from the GET request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Ensure page is at least 1
if ($page < 1) $page = 1;

// Reset all filters if the reset button is clicked
$filterFields = ['manufacturer', 'vehicleType', 'location', 'transmission', 'fuelType', 'seats', 'doors']; // List of all filters

if (isset($_GET['reset'])) {
   // Empty all filters
    foreach ($filterFields as $field) {
        $$field = ''; 
    }

    $gps = '';
    $climate = '';

    // Redirect to the product overview page to reset the filters
    header("Location: Productoverview.php");
    exit();
} else {
    // Populate filter values from the form submission
    foreach ($filterFields as $field) {
        $$field = isset($_GET[$field]) ? $_GET[$field] : '';
    }
}


// Build the filter conditions for the SQL query based on the selected filters
$filterConditions = "";

if (!empty($location)) {
    $filterConditions .= " AND l.City = '" . $conn->real_escape_string($location) . "'";
}
if (!empty($manufacturer)) {
    $filterConditions .= " AND m.Manufacturer = '" . $conn->real_escape_string($manufacturer) . "'";
}
if (!empty($vehicleType)) {
    $filterConditions .= " AND m.VehicleType = '" . $conn->real_escape_string($vehicleType) . "'";
}
if (!empty($transmission)) {
    $filterConditions .= " AND m.Transmission = '" . $conn->real_escape_string($transmission) . "'";
}
if (!empty($fuelType)) {
    $filterConditions .= " AND m.FuelType = '" . $conn->real_escape_string($fuelType) . "'";
}
if (!empty($seats)) {
    $filterConditions .= " AND m.SeatCount = '" . (int)$seats . "'";
}
if (!empty($doors)) {
    $filterConditions .= " AND m.Doors = '" . (int)$doors . "'";
}
if (!empty($climate)) {
    $filterConditions .= " AND m.ClimateControl = 1";
}
if (!empty($gps)) {
    $filterConditions .= " AND m.GPS = 1";
}
if (!empty($age)) {
    $filterConditions .= " AND v.Year >= YEAR(CURDATE()) - " . (int)$age;
}
if (!empty($drive)) {
    $filterConditions .= " AND m.DriveType = '" . $conn->real_escape_string($drive) . "'";
}
if (!empty($price)) {
    $filterConditions .= " AND m.PricePerDay <= " . (float)$price;
}

// Base query to filter available vehicles based on the selected criteria
$sql_filtered = "SELECT m.ModelID, m.ImagePath, m.Manufacturer, m.ModelName, m.VehicleType, 
                        m.SeatCount, m.Transmission, m.FuelType, m.PricePerDay, l.City, 
                        COUNT(filtered_vehicles.VehicleID) AS AvailableCount
                 FROM (
                     SELECT v.VehicleID, v.ModelID, v.LocationID
                     FROM Vehicles v
                     JOIN VehicleModels m ON v.ModelID = m.ModelID
                     JOIN Locations l ON v.LocationID = l.LocationID
                     WHERE v.VehicleID NOT IN (
                         SELECT b.VehicleID 
                         FROM bookings b
                         WHERE (b.StartDate <= '$return' AND b.EndDate >= '$pickup')
                     )
                     $filterConditions
                 ) AS filtered_vehicles
                 JOIN VehicleModels m ON filtered_vehicles.ModelID = m.ModelID
                 JOIN Locations l ON filtered_vehicles.LocationID = l.LocationID
                 GROUP BY m.ModelID, l.City";

// Query to count the total number of results based on the filters
$sql_count = "SELECT COUNT(*) AS total
              FROM (
                  SELECT m.ModelID, l.City
                  FROM (
                      SELECT v.VehicleID, v.ModelID, v.LocationID
                      FROM Vehicles v
                      JOIN VehicleModels m ON v.ModelID = m.ModelID
                      JOIN Locations l ON v.LocationID = l.LocationID
                      WHERE v.VehicleID NOT IN (
                          SELECT b.VehicleID 
                          FROM bookings b
                          WHERE (b.StartDate <= '$return' AND b.EndDate >= '$pickup')
                      )
                      $filterConditions
                  ) AS filtered_vehicles
                  JOIN VehicleModels m ON filtered_vehicles.ModelID = m.ModelID
                  JOIN Locations l ON filtered_vehicles.LocationID = l.LocationID
                  GROUP BY m.ModelID, l.City
              ) AS grouped_results";

// Execute the count query
$result_count = $conn->query($sql_count);
if (!$result_count) {
    die("Error in count query: " . $conn->error);
}
$row_count = $result_count->fetch_assoc();
$totalResults = $row_count['total'];

// Pagination setup
$limit = 5; // Number of results per page
$totalPages = ($totalResults > 0) ? ceil($totalResults / $limit) : 1;
$page = max(1, min($page, $totalPages)); // Ensure valid page number
$offset = ($page - 1) * $limit;

// Final filtered query with pagination
$sql_filtered .= " ORDER BY $sort LIMIT $limit OFFSET $offset";
$result_filtered = $conn->query($sql_filtered);
if (!$result_filtered) {
    die("Error in filtered query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produktübersicht - Autovermietung</title>
    <link rel="stylesheet" href="styles.css">
    
    <style>
        

        /* <General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        p {
            color: #ccc;
        }

        body {
            background: linear-gradient(135deg, #1e1e1e, #3a3a3a);
            display: inline-block;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Backgrounf effect */
        .background {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('assets/bg-pattern.jpg') no-repeat center center/cover;
            filter: blur(8px);
            z-index: -1;
        }

        /* filter-container */
        .filter-container {
            background: rgba(255, 255, 255, 0.36);
            backdrop-filter: blur(15px);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 3000px;
            text-align: center;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .filter-container:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        h1 {
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 25px;
        }

        label {
            font-weight: 400;
            text-align: left;
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        /* Responsiveness */
        @media (max-width: 480px) {
            .filter-container {
                width: 90%;
                padding: 40px;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #222; /* Dark background */
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #555; /* Border color */
            color: white; /* Set text color to white */
        }

        th {
            background-color: #ff1a1a; /* Red header background */
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #333; /* Slightly lighter for contrast */
        }

        span {
            color: white;
        }

        /* Styles for the car list and popup */
        .car-list { display: flex; flex-wrap: wrap; gap: 20px; }
        .car-item { border: 1px solid #ddd; padding: 10px; cursor: pointer; }
        .car-item img { width: 150px; height: auto; }
        .details-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            max-height: 80vh;
            overflow-y: auto;
            z-index: 1000; /* Ensure it appears on top */
            border: 2px solid #ddd;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 24px;
            font-weight: bold;
            color: red; /* Make it visible */
            background: white;
            border: none;
            outline: none;
            padding: 5px;
        }

        .close-btn:hover {
            color: darkred;
        }

        /* Dark overlay when popup is open */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .details-container {
            display: flex;
            align-items: center;
            gap: 20px; /* Adds spacing between the image and text */
        }

        .details-container img {
            max-width: 250px;
            border-radius: 8px;
        }

        .details-text {
            flex: 1;
            font-size: 16px;
            color: #222; /* Darker text for better readability */
        }

        .selected-period {
            font-weight: bold;
            color: #111; /* Even darker for emphasis */
            margin-top: 10px;
        }
        
        .pagination {
            margin-top: 20px;
            text-align: center;
        }   

        .button {
            display: inline-block;
            padding: 12px 18px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            color: white;
            border-radius: 8px;
            margin: 0 8px;
            transition: all 0.3s ease-in-out;
            background: linear-gradient(45deg, #ff3c3c, #b30000);
            box-shadow: 0px 4px 10px rgba(255, 0, 0, 0.3);
            border: none;
        }

        .button:hover {
            background: linear-gradient(45deg, #ff0000, #800000);
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(255, 0, 0, 0.5);
        }

        .button.disabled {
            background: #555;
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.5;
        }

        /* Toast Notification Styles */
        .toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #4CAF50; /* Green background for success */
            color: white;
            text-align: center;
            border-radius: 5px;
            padding: 16px;
            position: fixed;
            z-index: 1000;
            right: 20px;
            top: 20px;
            font-size: 16px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {top: 0; opacity: 0;}
            to {top: 20px; opacity: 1;}
        }

        @keyframes fadeout {
            from {top: 20px; opacity: 1;}
            to {top: 0; opacity: 0;}
        }
    </style>
</head>
<body>
    <div class="background"></div> 

    <div class="filter-container">
    <h1>Verfügbare Fahrzeuge</h1>
    
    <!-- Filter Form -->
    <form method="GET" action="Productoverview.php">
        <label for="location">Standort:</label>
        <select id="location" name="location">
            <option value="">alle</option>
            <option value="Berlin" <?= $location == 'Berlin' ? 'selected' : '' ?>>Berlin</option>
            <option value="Hamburg" <?= $location == 'Hamburg' ? 'selected' : '' ?>>Hamburg</option>
            <option value="München" <?= $location == 'München' ? 'selected' : '' ?>>München</option>
            <option value="Köln" <?= $location == 'Köln' ? 'selected' : '' ?>>Köln</option>
            <option value="Bochum" <?= $location == 'Bochum' ? 'selected' : '' ?>>Bochum</option>
            <option value="Rostock" <?= $location == 'Rostock' ? 'selected' : '' ?>>Rostock</option>
            <option value="Paderborn" <?= $location == 'Paderborn' ? 'selected' : '' ?>>Paderborn</option>
            <option value="Leipzig" <?= $location == 'Leipzig' ? 'selected' : '' ?>>Leipzig</option>
            <option value="Dortmund" <?= $location == 'Dortmund' ? 'selected' : '' ?>>Dortmund</option>
            <option value="Freiburg" <?= $location == 'Freiburg' ? 'selected' : '' ?>>Freiburg</option>
            <option value="Bremen" <?= $location == 'Bremen' ? 'selected' : '' ?>>Bremen</option>
            <option value="Dresden" <?= $location == 'Dresden' ? 'selected' : '' ?>>Dresden</option>
            <option value="Bielefeld" <?= $location == 'Bielefeld' ? 'selected' : '' ?>>Bielefeld</option>
            <option value="Nürnberg" <?= $location == 'Nürnberg' ? 'selected' : '' ?>>Nürnberg</option>
        </select>

        <label for="pickup">Abholdatum:</label>
            <input type="date" id="pickup" name="pickup" value="<?php echo htmlspecialchars($pickup); ?>">

            <label for="return">Rückgabedatum:</label>
            <input type="date" id="return" name="return" value="<?php echo htmlspecialchars($return); ?>">
        
        <label for="manufacturer">Hersteller:</label>
        <select id="manufacturer" name="manufacturer">
        <option value="" <?= $manufacturer == '' ? 'selected' : '' ?>>Alle</option>
        <option value="BMW" <?= $manufacturer == 'BMW' ? 'selected' : '' ?>>BMW</option>
        <option value="Audi" <?= $manufacturer == 'Audi' ? 'selected' : '' ?>>Audi</option>
        <option value="Ford" <?= $manufacturer == 'Ford' ? 'selected' : '' ?>>Ford</option>
        <option value="Volkswagen" <?= $manufacturer == 'Volkswagen' ? 'selected' : '' ?>>Volkswagen</option>
        <option value="Opel" <?= $manufacturer == 'Opel' ? 'selected' : '' ?>>Opel</option>
        <option value="Skoda" <?= $manufacturer == 'Skoda' ? 'selected' : '' ?>>Skoda</option>
        </select>

        <label for="seats">Sitze:</label>
        <select id="seats" name="seats">
            <option value="" <?= $seats == '' ? 'selected' : '' ?>>alle</option>
            <option value="2" <?= $seats == 2 ? 'selected' : '' ?>>2</option>
            <option value="4" <?= $seats == 4 ? 'selected' : '' ?>>4</option>
            <option value="5" <?= $seats == 5 ? 'selected' : '' ?>>5</option>
            <option value="7" <?= $seats == 7 ? 'selected' : '' ?>>7</option>
            <option value="9" <?= $seats == 9 ? 'selected' : '' ?>>9</option>
        </select>

        <label for="doors">Türen:</label>
        <select id="doors" name="doors">
            <option value="" <?= $doors == '' ? 'selected' : '' ?>>alle</option>
            <option value="2" <?= $doors == 2 ? 'selected' : '' ?>>2</option>
            <option value="3" <?= $doors == 3 ? 'selected' : '' ?>>3</option>
            <option value="4" <?= $doors == 4 ? 'selected' : '' ?>>4</option>
            <option value="5" <?= $doors == 5 ? 'selected' : '' ?>>5</option>
        </select>
        
        <label for="transmission">Getriebe:</label>
        <select id="transmission" name="transmission">
            <option value="" <?= $transmission == '' ? 'selected' : '' ?>>Alle</option>
            <option value="Automatikschaltung" <?= $transmission == 'Automatikschaltung' ? 'selected' : '' ?>>Automatikschaltung</option>
            <option value="manuelle Schaltung" <?= $transmission == 'manuelle Schaltung' ? 'selected' : '' ?>>manuelle Schaltung</option>
        </select>
        
        <label>
            GPS
            <input type="checkbox" name="gps" value="1" <?php if(isset($_GET['gps'])) echo 'checked'; ?>>
        </label>

        <label>
            Klimaanlage
            <input type="checkbox" name="climate" value="1" <?php if(isset($_GET['climate'])) echo 'checked'; ?>>
        </label>

        
        <label for="vehicleType">Typ:</label>
        <select id="vehicleType" name="vehicleType">
            <option value="" <?= $vehicleType == '' ? 'selected' : '' ?>>Alle</option>
            <option value="Limousine" <?= $vehicleType == 'Limousine' ? 'selected' : '' ?>>Limousine</option>
            <option value="3-Türer" <?= $vehicleType == '3-Türer' ? 'selected' : '' ?>>3-Türer</option>
            <option value="Combi" <?= $vehicleType == 'Combi' ? 'selected' : '' ?>>Combi</option>
            <option value="Cabrio" <?= $vehicleType == 'Cabrio' ? 'selected' : '' ?>>Cabrio</option>
            <option value="Turnier" <?= $vehicleType == 'Turnier' ? 'selected' : '' ?>>Turnier</option>
            <option value="Aut." <?= $vehicleType == 'Aut.' ? 'selected' : '' ?>>Aut.</option>
            <option value="Touring" <?= $vehicleType == 'Touring' ? 'selected' : '' ?>>Touring</option>
            <option value="Allspace" <?= $vehicleType == 'Allspace' ? 'selected' : '' ?>>Allspace</option>
            <option value="Cabriolet" <?= $vehicleType == 'Cabriolet' ? 'selected' : '' ?>>Cabriolet</option>
            <option value="T-Modell" <?= $vehicleType == 'T-Modell' ? 'selected' : '' ?>>T-Modell</option>
            <option value="Touring Aut." <?= $vehicleType == 'Touring Aut.' ? 'selected' : '' ?>>Touring Aut.</option>
            <option value="Coupé" <?= $vehicleType == 'Coupé' ? 'selected' : '' ?>>Coupé</option>
            <option value="Transporter" <?= $vehicleType == 'Transporter' ? 'selected' : '' ?>>Transporter</option>
            <option value="Roadster" <?= $vehicleType == 'Roadster' ? 'selected' : '' ?>>Roadster</option>
        </select>

        <label for="drive">Antrieb:</label>
            <select id="drive" name="drive">
                <option value="" <?= $drive == '' ? 'selected' : '' ?>>Alle</option>
                <option value="FWD" <?= $drive == 'FWD' ? 'selected' : '' ?>>Frontantrieb (FWD)</option>
                <option value="RWD" <?= $drive == 'RWD' ? 'selected' : '' ?>>Heckantrieb (RWD)</option>
                <option value="AWD" <?= $drive == 'AWD' ? 'selected' : '' ?>>Allradantrieb (AWD)</option>
                <option value="4WD" <?= $drive == '4WD' ? 'selected' : '' ?>>4x4 (4WD)</option>
            </select>
        
        <label for="fuelType">Kraftstoff:</label>
        <select id="fuelType" name="fuelType">
            <option value="" <?= $fuelType == '' ? 'selected' : '' ?>>Alle</option>
            <option value="Diesel" <?= $fuelType == 'Diesel' ? 'selected' : '' ?>>Diesel</option>
            <option value="Elektro" <?= $fuelType == 'Elektro' ? 'selected' : '' ?>>Elektro</option>
            <option value="Hybrid" <?= $fuelType == 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
            <option value="Benzin" <?= $fuelType == 'Benzin' ? 'selected' : '' ?>>Benzin</option>
        </select>

        <label for="price">Preis bis:</label>
            <input type="number" id="price" name="price" min="0" step="1" value="<?= htmlspecialchars($price) ?>">
        
        <label for="sort">Sortiere nach:</label>
            <select id="sort" name="sort">
                <option value="PricePerDay ASC" <?= ($sort == 'PricePerDay ASC') ? 'selected' : '' ?>>Preis Aufsteigend</option>
                <option value="PricePerDay DESC" <?= ($sort == 'PricePerDay DESC') ? 'selected' : '' ?>>Preis Absteigend</option>
            </select>

        
        <button type="submit" name="filter" value="1">Filtern</button>
        <button type="submit" name="reset" value="1" onclick="clearCheckboxes()">Filter zurücksetzen</button>
        <a href="index.php" style="display: inline-block; padding: 6px 12px; background-color: #ccc; color: black; text-decoration: none; border-radius: 4px; margin-left: 10px;">
        Gesamte Auswahl zurücksetzen
        </a>
        </form>
        </div>
    
        <table border="1">
            <tr>
                <th>Bild</th>
                <th>Hersteller</th>
                <th>Modell</th>
                <th>Typ</th>
                <th>Sitze</th>
                <th>Getriebe</th>
                <th>Kraftstoff</th>
                <th>Preis pro Tag</th>
                <th>Standort</th>
            </tr>
            <?php while ($row = $result_filtered->fetch_assoc()): ?>
                <tr class="car-item" data-id="<?= $row['ModelID']; ?>" data-city="<?= htmlspecialchars($row['City']); ?>">
                    <td>
                        <?php if (!empty($row['ImagePath'])): ?>
                            <img src="<?= htmlspecialchars($row['ImagePath']) ?>" alt="<?= htmlspecialchars($row['ImagePath']) ?>" width="100" height="100" style="border-radius: 8px;">
                            <span style="font-size: 12px; color: #fff; background-color: #4CAF50; padding: 2px 5px; border-radius: 3px; margin-left: 5px;">
                                x<?= htmlspecialchars($row['AvailableCount']); ?>
                            </span>
                        <?php else: ?>
                            <span style="color: red;">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['Manufacturer']); ?></td>
                    <td><?= htmlspecialchars($row['ModelName']); ?></td>
                    <td><?= htmlspecialchars($row['VehicleType']); ?></td>
                    <td><?= htmlspecialchars($row['SeatCount']); ?></td>
                    <td><?= htmlspecialchars($row['Transmission']); ?></td>
                    <td><?= htmlspecialchars($row['FuelType']); ?></td>
                    <td><?= htmlspecialchars($row['PricePerDay']); ?> €</td>
                    <td><?= htmlspecialchars($row['City']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    
    <!-- Pop-up für Fahrzeugdetails -->
    <div class="details-popup" id="detailsPopup">
        <span class="close-btn" onclick="hidePopup()">X</span>
        <div id="detailsContent"></div>
    </div>

    <div class="pagination">
    <!-- Previous Button -->
    <a href="?<?= http_build_query(array_merge($_GET, ['page' => max(1, $page - 1)])) ?>" 
       class="button <?= ($page <= 1) ? 'disabled' : '' ?>">❮ Prev</a>

    <!-- Page Info -->
    <span>Page <?= $page ?> of <?= $totalPages ?></span>

    <!-- Next Button -->
    <a href="?<?= http_build_query(array_merge($_GET, ['page' => min($totalPages, $page + 1)])) ?>" 
       class="button <?= ($page >= $totalPages) ? 'disabled' : '' ?>">Next ❯</a>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>

</body>
<script>
    // Check for booking success message
    <?php if (isset($_SESSION['booking_success'])): ?>
        showToast("<?php echo $_SESSION['booking_success']; ?>", "success");
        <?php unset($_SESSION['booking_success']); // Clear the message after displaying ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['booking_error'])): ?>
        showToast("<?php echo $_SESSION['booking_error']; ?>", "error");
        <?php unset($_SESSION['booking_error']); // Clear the message after displaying ?>
    <?php endif; ?>

    // Function to show toast notification
    function showToast(message, type) {
        const toast = document.getElementById("toast");
        toast.textContent = message;
        toast.className = "toast show";

        // Set background color based on type
        if (type === "success") {
            toast.style.backgroundColor = "#4CAF50"; // Green for success
        } else if (type === "error") {
            toast.style.backgroundColor = "#f44336"; // Red for error
        }

        // Hide the toast after 3 seconds
        setTimeout(() => {
            toast.className = toast.className.replace("show", "");
        }, 3000);
    }
</script>
<script>
    function clearCheckboxes() {
        document.querySelectorAll('input[type=checkbox]').forEach(checkbox => checkbox.checked = false);
    }
</script>
<script>
    // Function to clear all checkboxes in the form
    function clearCheckboxes() {
        // Select all input elements of type 'checkbox' and uncheck them
        document.querySelectorAll('input[type=checkbox]').forEach(checkbox => checkbox.checked = false);
    }
</script>

<script>
// Wait for the DOM to be fully loaded before executing the script
document.addEventListener("DOMContentLoaded", function () {
    // Select all elements with the class 'car-item' (each car in the list)
    document.querySelectorAll(".car-item").forEach(function (item) {
        // Add a click event listener to each car item
        item.addEventListener("click", function () {
            // Get the model ID and city from the data attributes of the clicked car item
            let modelId = this.dataset.id;
            let city = this.dataset.city;

            // Get the pickup and return dates from the form inputs, if they exist
            let pickup = document.getElementById("pickup") ? document.getElementById("pickup").value : "";
            let returnDate = document.getElementById("return") ? document.getElementById("return").value : "";

            // Create a new XMLHttpRequest object to send a request to the server
            let xhr = new XMLHttpRequest();
            // Open a POST request to the 'get_car_details.php' endpoint
            xhr.open("POST", "get_car_details.php", true);
            // Set the request header to indicate the content type
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Define the callback function to handle the response
            xhr.onreadystatechange = function () {
                // Check if the request is complete and successful
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Update the content of the popup with the response from the server
                    document.getElementById("detailsContent").innerHTML = xhr.responseText;
                    // Display the popup
                    document.getElementById("detailsPopup").style.display = "block";
                }
            };

            // Send the request with the car details as URL-encoded data
            xhr.send("modelId=" + modelId + "&city=" + city + "&pickup=" + pickup + "&return=" + returnDate);
        });
    });
});

// Function to hide the details popup
function hidePopup() {
    // Hide the popup by setting its display style to 'none'
    document.getElementById("detailsPopup").style.display = "none";
}
</script>
</html>

<?php $conn->close(); ?>
