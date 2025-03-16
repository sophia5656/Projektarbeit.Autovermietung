

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Details</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Container for vehicle details */
        .vehicle-container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            align-items: center;
            gap: 30px;
        }

        /* Image section */
        .image-container {
            flex: 1;
        }

        /* Styling for vehicle image */
        .vehicle-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Details section */
        .details-container {
            flex: 1;
            text-align: left;
        }

        /* Vehicle title */
        h1 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 15px;
        }

        /* Styling for vehicle details */
        .vehicle-details p {
            margin: 10px 0;
            font-size: 1.1rem;
            color: #555;
            line-height: 1.6;
        }

        /* Booking button & Back button*/
        .booking-btn,   .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 14px 24px;
            background-color: rgb(255, 0, 43);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for the both buttons */
        .booking-btn:hover, .back-btn:hover {
            background-color: rgb(193, 96, 112);
        }

    </style>
</head>
<body>

    <!-- Main container for vehicle details -->
    <div class="vehicle-container">
        <!-- Image container -->
        <div class="image-container">
            <img id="vehicle-image" src="default-car.jpg" alt="Vehicle Image" class="vehicle-image">
        </div>
        
        <!-- Container for vehicle information -->
        <div class="details-container">
            <h1 id="vehicle-title">Fahrzeugmodell XYZ</h1>
            <div class="vehicle-details">
                <p><strong>Marke:</strong> <span id="manufacturer"></span></p>
                <p><strong>Modell:</strong> <span id="model"></span></p>
                <p><strong>PS:</strong> <span id="horsepower"></span></p>
                <p><strong>Kraftstoff:</strong> <span id="fuel"></span></p>
                <p><strong>Sitze:</strong> <span id="seats"></span></p>
                <p><strong>Getriebe:</strong> <span id="transmission"></span></p>
            </div>
            <!-- Booking button -->
            <a href="#" class="booking-btn">Buchung starten</a>

            <!-- Back to Product Overview Button -->
            <a href="productoverview.php" class="back-btn">Zurück zur Produktübersicht</a>
        </div>
    </div>

    <script>
        // Function to get query parameters from URL
function getQueryParam(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name) || 'Nicht angegeben';
}

// Get filter values from URL
let location = getQueryParam("location");
let manufacturer = getQueryParam("manufacturer");
let model = getQueryParam("model");

console.log("Received filters:", { location, manufacturer, model }); // Debugging

// Sample Car Database (replace with real database later)
var cars = [
    { 
        manufacturer: "BMW", 
        model: "X5", 
        seats: 5, 
        doors: 4, 
        transmission: "Automatik", 
        horsepower: "300 PS", 
        fuel: "Benzin", 
        price: "156.99 €", 
        image: "bmw_x5.jpg"
    },
    { 
        manufacturer: "Audi", 
        model: "A3", 
        seats: 5, 
        doors: 4, 
        transmission: "Manuell", 
        horsepower: "250 PS", 
        fuel: "Diesel", 
        price: "110.50 €", 
        image: "audi_a3.jpg"
    }
];

// Find selected car in the database
var selectedCar = cars.find(car => car.manufacturer === manufacturer && car.model === model);

// Display the car details or show error message
if (selectedCar) {
    document.getElementById("manufacturer").textContent = selectedCar.manufacturer;
    document.getElementById("model").textContent = selectedCar.model;
    document.getElementById("seats").textContent = selectedCar.seats;
    document.getElementById("doors").textContent = selectedCar.doors;
    document.getElementById("transmission").textContent = selectedCar.transmission;
    document.getElementById("horsepower").textContent = selectedCar.horsepower;
    document.getElementById("fuel").textContent = selectedCar.fuel;
    document.getElementById("price").textContent = selectedCar.price;
    document.getElementById("vehicle-image").src = selectedCar.image;
} else {
    document.getElementById("vehicle-title").textContent = "Fahrzeug nicht gefunden";
    document.querySelector(".vehicle-details").innerHTML = "<p>Kein Fahrzeug gefunden.</p>";
    document.getElementById("vehicle-image").src = "default-car.jpg";
}
    </script>

</body>
</html>