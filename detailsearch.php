<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "car_rental");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default SQL query (no filters, show all cars)
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suchergebnisse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            text-align: center;
            padding: 20px;
        }

        .results {
            text-align: left;
            width: 80%;
            margin: auto;
        }

        .car {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .search-btn {
            padding: 10px 15px;
            background-color: rgb(255, 0, 43);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .search-btn:hover {
            background-color: rgb(200, 0, 30);
        }
    </style>
</head>
<body>

    <h1>Suchergebnisse</h1>

    <div class="results">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="car">
                    <p><strong>Marke:</strong> <?= htmlspecialchars($row['brand']); ?></p>
                    <p><strong>Modell:</strong> <?= htmlspecialchars($row['model']); ?></p>
                    <p><strong>PS:</strong> <?= $row['ps']; ?></p>
                    <p><strong>Kraftstoff:</strong> <?= htmlspecialchars($row['fuel_type']); ?></p>
                    <p><strong>Preis pro Tag:</strong> <?= number_format($row['price_per_day'], 2, ',', '.') . " €"; ?></p>
                    
                    <!-- Link to cardetail.php with car ID -->
                    <a href="cardetails.php?id=<?= $row['id']; ?>" class="search-btn">Details anzeigen</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Keine Fahrzeuge gefunden.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>