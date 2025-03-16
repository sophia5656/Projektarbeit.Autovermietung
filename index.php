<!DOCTYPE html>
<html lang="en">
    <?php
    // Include the header file (header.php)
    include("header.php");
    ?>
    
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autovermietung SSJ</title>
    <style>
        /* General reset for all elements */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Header positioning */
        header {
            position: absolute;
            z-index: 1001;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            color: white;
            overflow-x: hidden;
            background-color: #17202a;
        }

        /* Container for the main content */
        .container {
            position: relative;
            height: 100vh;
            display: flex;
            justify-content: flex-start;
            align-items: flex-end;
            padding: 20px;
        }

        /* Background video styling */
        .background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.5);
        }

        /* Content overlay styling */
        .content {
            position: absolute;
            bottom: 50px;
            left: 50px;
        }

            .content h1 {
                font-size: 3rem;
                margin-bottom: 20px;
                text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
            }

            .content p {
                font-size: 1.2rem;
                margin-bottom: 30px;
                text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
            }

        /* Buttons styling */
        .buttons {
            display: flex;
            gap: 20px;
        }

        .btn {
            padding: 15px 30px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s ease;
            text-transform: uppercase;
        }

            .btn:hover {
                transform: scale(1.1);
            }

        .btn-watch {
            background-color: #e50914;
            color: white;
        }

        .btn-more {
            background-color: rgba(255, 255, 255, 0.8);
            color: black;
        }
        
        /* Vehicle Classes Section (Static Grid) */
        .vehicle-classes {
            display: flex;
            flex-wrap: wrap; /* Allows wrapping to the next line if necessary */
            gap: 20px; /* Space between images */
            justify-content: center; /* Centers items horizontally */
            padding: 20px 0;
        }

        .vehicle-class-item {
            flex: 0 0 150px; /* Fixed width */
            height: 100px; /* Fixed height */
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            text-decoration: none; /* Removes underline from links */
        }

        .vehicle-class-item:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.5);
        }

        .vehicle-class-text {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        /* Carousels styling */
        .carousel-wrapper {
            position: relative;
        }

        .carousel {
            margin: 20px 0;
            padding: 20px;
            overflow: hidden;
            display: flex;
            scroll-behavior: smooth;
        }

        .carousel-item {
            flex: 0 0 auto;
            width: 200px;
            height: 300px;
            margin-right: 15px;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); /* Shadow added */
        }

        .carousel-item:hover {
            transform: scale(1.1); /* Scale up on hover */
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.5); /* Intensify shadow */
        }

        .carousel-item-text {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            padding: 10px;
            cursor: pointer;
            z-index: 1;
        }

        .carousel-button.left {
            left: 10px;
        }

        .carousel-button.right {
            right: 10px;
        }

        .section {
            padding: 20px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            position: relative;
        }

        .section-header:hover .browse-all {
            display: inline;
        }

        .section-header h2 {
            margin: 0;
        }

        .section-header .btn-all {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .section-header .btn-all:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }

        .browse-all {
            display: none;
            color: turquoise;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        .browse-all:hover {
            color: cyan;
        }

        
        /* Filter container styling */
        .filter-container {
            background: white;
            padding: 20px;
            margin: 30px auto 0 auto;
            text-align: center;
            border-radius: 15px;
            max-width: 900px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 10px;
            z-index: 1000;
        }

        .filter-container form {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-container label, .filter-container select, .filter-container input, .filter-container button {
            margin: 5px;
            padding: 10px;
            font-size: 16px;
            color: black;
        }

        .filter-container select, .filter-container input {
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-container button {
            background-color: #e50914;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Review section styling */
        .review-section {
            width: 100%;
            text-align: center;
            padding: 50px 20px;
            background-image: url('reviews-background.jpg');
            background-size: cover;
            background-position: center;
        }

        .review-section h2 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .review-carousel {
            display: flex;
            overflow: hidden;
            scroll-behavior: smooth;
            justify-content: center;
            padding: 20px;
        }

        .review-item {
            flex: 0 0 80%;
            margin: 0 10px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 10px;
            font-size: 1.2rem;
            text-align: center;
        }

        /* Vignette effect for the entire website except Header*/
        .vignette {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px; /* Height of the effect */
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0));
            pointer-events: none; /* Prevents blocking clicks */
            z-index: 999;
        }
    </style>
</head>
<body>
    
     <!-- Main container for the intro section -->
    <div class="container">
        <!-- Background video for the intro section -->
        <video class="background-video" autoplay muted loop>
            <source src="assets/introauto.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Content overlay for the intro section -->
        <div class="content">
            <h1>Finde Dein Auto</h1>
            <p>Buche Dein Auto jederzeit, überall.</p>
            <div class="buttons">
                <!-- Button für das Dummy-Video -->
                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="btn btn-watch" style="text-decoration: none;">Video anschauen</a>
                
                <!-- Button für die Dummy-Weiterleitung -->
                <a href="https://de.wikipedia.org/wiki/Automobil" target="_blank" class="btn btn-more" style="text-decoration: none;">Mehr lernen</a>
            </div>
        </div>
    </div>

    <!-- Adds a vignette effect to the entire Website (see above)-->
    <div class="vignette"></div>
    
    <!-- Filter container for searching vehicles -->
    <div class="filter-container">
        <form action="productoverview.php" method="GET">
            <label for="location">Ort:</label>
            <select id="location" name="location" required>
                <option value="Berlin">Berlin</option>
                <option value="Hamburg">Hamburg</option>
                <option value="München">München</option>
                <option value="Köln">Köln</option>
                <option value="Bochum">Bochum</option>
                <option value="Rostock">Rostock</option>
                <option value="Paderborn">Paderborn</option>
                <option value="Leipzig">Leipzig</option>
                <option value="Dortmund">Dortmund</option>
                <option value="Freiburg">Freiburg</option>
                <option value="Bremen">Bremen</option>
                <option value="Dresden">Dresden</option>
                <option value="Bielefeld">Bielefeld</option>
                <option value="Nürnberg">Nürnberg</option>
            </select>

            <label for="pickup">Abholdatum:</label>
            <input type="date" id="pickup" name="pickup" required>

            <label for="return">Rückgabedatum:</label>
            <input type="date" id="return" name="return" required>

            <button type="submit">Autos anzeigen</button>
        </form>
    </div>

    <!-- Vehicle Classes Carousel -->
    <div class="section">
        <div class="section-header">
            <h2>Beliebte Fahrzeugklassen</h2>
            <a href="#" class="browse-all">Alle durchstöbern</a>
        </div>
        <div class="vehicle-classes">
                <a href="Productoverview.php?vehicleType=Cabrio" class="vehicle-class-item" style="background-image: url('assets/cabrio.jpg');">
                    <div class="vehicle-class-text">Cabrios</div>
                </a>
                <a href="Productoverview.php?vehicleType=Cabriolet" class="vehicle-class-item" style="background-image: url('assets/cabriolet.png');">
                    <div class="vehicle-class-text">Cabriolets</div>
                </a>
                <a href="Productoverview.php?vehicleType=Combi" class="vehicle-class-item" style="background-image: url('assets/kombi.jpg');">
                    <div class="vehicle-class-text">Combis</div>
                </a>
                <a href="Productoverview.php?vehicleType=Coupe" class="vehicle-class-item" style="background-image: url('assets/coupe.jpg');">
                    <div class="vehicle-class-text">Coupés</div>
                </a>
                <a href="Productoverview.php?vehicleType=Limousine" class="vehicle-class-item" style="background-image: url('assets/limousine.jpg');">
                    <div class="vehicle-class-text">Limousinen</div>
                </a>
                <a href="Productoverview.php?vehicleType=Transporter" class="vehicle-class-item" style="background-image: url('assets/mehrsitzer.png');">
                    <div class="vehicle-class-text">Mehrsitzer</div>
                </a>
                <a href="Productoverview.php?vehicleType=SUV" class="vehicle-class-item" style="background-image: url('assets/suv.jpg');">
                    <div class="vehicle-class-text">SUVs</div>
                </a>
        </div>
    </div>

    <!-- Cities Carousel Section -->
    <div class="section">
        <div class="section-header">
            <h2>Städte</h2>
            <a href="#" class="browse-all">Alle durchstöbern</a>
        </div>
        <div class="carousel-wrapper">
        <button class="carousel-button left" onclick="scrollCarousel('cities', -1)">&lt;</button>
        <div class="carousel" id="cities">
            <a href="Productoverview.php?location=Hamburg" class="carousel-item" style="background-image: url('assets/hamburg.jpg');">
                <div class="carousel-item-text">Hamburg</div>
            </a>
            <a href="Productoverview.php?location=Berlin" class="carousel-item" style="background-image: url('assets/berlin.jpg');">
                <div class="carousel-item-text">Berlin</div>
            </a>
            <a href="Productoverview.php?location=Bielefeld" class="carousel-item" style="background-image: url('assets/bielefeld.jpg');">
                <div class="carousel-item-text">Bielefeld</div>
            </a>
            <a href="Productoverview.php?location=Bochum" class="carousel-item" style="background-image: url('assets/bochum.jpg');">
                <div class="carousel-item-text">Bochum</div>
            </a>
            <a href="Productoverview.php?location=Bremen" class="carousel-item" style="background-image: url('assets/bremen.jpg');">
                <div class="carousel-item-text">Bremen</div>
            </a>
            <a href="Productoverview.php?location=Dortmund" class="carousel-item" style="background-image: url('assets/dortmund.jpg');">
                <div class="carousel-item-text">Dortmund</div>
            </a>
            <a href="Productoverview.php?location=Dresden" class="carousel-item" style="background-image: url('assets/dresden.jpg');">
                <div class="carousel-item-text">Dresden</div>
            </a>
            <a href="Productoverview.php?location=Freiburg" class="carousel-item" style="background-image: url('assets/freiburg.jpg');">
                <div class="carousel-item-text">Freiburg</div>
            </a>
            <a href="Productoverview.php?location=Köln" class="carousel-item" style="background-image: url('assets/köln.jpg');">
                <div class="carousel-item-text">Köln</div>
            </a>
            <a href="Productoverview.php?location=Leipzig" class="carousel-item" style="background-image: url('assets/leipzig.jpg');">
                <div class="carousel-item-text">Leipzig</div>
            </a>
            <a href="Productoverview.php?location=München" class="carousel-item" style="background-image: url('assets/münchen.jpg');">
                <div class="carousel-item-text">München</div>
            </a>
            <a href="Productoverview.php?location=Nürnberg" class="carousel-item" style="background-image: url('assets/nürnberg.jpg');">
                <div class="carousel-item-text">Nürnberg</div>
            </a>
            <a href="Productoverview.php?location=Paderborn" class="carousel-item" style="background-image: url('assets/paderborn.jpg');">
                <div class="carousel-item-text">Paderborn</div>
            </a>
            <a href="Productoverview.php?location=Rostock" class="carousel-item" style="background-image: url('assets/rostock.jpg');">
                <div class="carousel-item-text">Rostock</div>
            </a>
            </div>
            <button class="carousel-button right" onclick="scrollCarousel('cities', 1)">&gt;</button>
        </div>
    </div>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Über uns - Vrooom</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Allgemeines Styling */
        body {
            background-color: #1e1e1e;
            color: white;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Über-uns Sektion */
        .about-section {
            background: linear-gradient(135deg, #222, #111);
            padding: 60px 20px;
            text-align: center;
        }

        .about-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .about-title {
            font-size: 2.5rem;
            color:#e5091;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .about-text {
            font-size: 1.2rem;
            color: #ccc;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        /* Vorteile Liste */
        .about-list {
            list-style: none;
            padding: 0;
            text-align: left;
            display: inline-block;
            margin: 20px auto;
        }

        .about-list li {
            font-size: 1.2rem;
            color: #eee;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .about-list li::before {
            content: "🚗";
            font-size: 1.5rem;
            margin-right: 15px;
            color:rgb(214, 22, 22);
        }

        /* Call-to-Action */
        .cta-button {
            background: linear-gradient(135deg, #ff4b2b, #ff2e63);
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .cta-button:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #ff2e63, #ff4b2b);
            box-shadow: 0 5px 15px rgba(255, 75, 43, 0.4);
        }


  /* Welches Auto passt zu Ihnen?*/
        .about-us-section {
           background-color:rgb(26, 26, 24);
           font-family: 'Poppins', sans-serif;
           padding: 50px 20px;  /* Add padding around the section */
           display: flex;
           justify-content: space-between;
           align-items: center;
           height: 400px;  /* Set a minimum height */
           height: auto; /* Allow height to adjust based on content */
           color: white;
           perspective: 1500px;  /* Add perspective for 3D effect */
        }
           .container-about-us {
           display: flex;
           flex-direction: row;
           justify-content: space-between;
           align-items: center;
           max-width: 1200px;
           width: 100%;
           flex-wrap: wrap;  /* Allow content to wrap on smaller screens */
           text-align: center; /* Center text */
        }

          .about-content {   /* Adjust the Size of text in About Us*/ 
          flex: 1;
          padding-right: 30px;
          max-width: 600px;  
          text-align: left;  /* Align text to the left */
        }

          .about-content h2 {
          font-size: 2.5rem;
          margin-bottom: 15px;
          font-weight: 600;
          color:#dddddd
          
        }

          .about-content p {
          font-size: 1.0rem;
          line-height: 1.8;
          
          color:#bbbbbb
        }

          .about-content .cta-button {
         padding: 15px 30px;
         background-color:rgb(33, 39, 49);  /* color for the CTA button */
         border: none;
         color: white;
         font-size: 16px;
         cursor: pointer;
         text-transform: uppercase;
         transition: transform 0.2s ease;
         border-radius: 5px;
       }
      
         .about-content .cta-button:hover {
         transform: scale(1.1);  /* Hover effect for the button */
       }
        .about-image {
         flex: 1;
         display: flex;
         justify-content: center;
         align-items: center;
         position: relative;
         transform-style: preserve-3d;  /* Enable 3D transformations for child elements */
         transition: transform 1s ease-in-out;
         }

         .about-image img {
          max-width: 100%; /*adjust the size of Photo*/
          height: auto;
          border-radius: 8px;  /* Optional: Add border radius for a rounded effect */
          object-fit: cover;  /* Ensure the image covers the space well */
          transform: translateZ(0px);  /* Initial position (no 3D effect) */
         transition: transform 1s ease-in-out;
    
        }
        .about-image:hover img {
         transform: translateZ(50px) rotateY(10deg);  /* Move image forward and rotate on hover */
       }

       /* Adjust for small screens */
        @media (max-width: 768px) {

        .about-us-container {
        flex-direction: column;
        text-align: center;
        }

         .about-image img {
         max-width: 80%;  /* Reduce image size on smaller screens */
        }
     }

     /* WhatsApp icon style */
         .whatsapp-icon {
         position: fixed;
         bottom: 20px; /* Distance from the bottom */
         right: 20px;   /* Move it to the right */
         background-color: #25D366; /* WhatsApp green color */
         padding: 15px;
         border-radius: 50%; /* Circular button */
         color: white;
         font-size: 30px; /* Icon size */
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);  /* Subtle shadow */
         transition: transform 0.3s ease-in-out;
        }

         /* Hover effect to slightly enlarge the icon */
         .whatsapp-icon:hover {
          transform: scale(1.1); /* Slightly increase the size on hover */
        }

          /* Optional: Position icon on smaller screens */
         @media (max-width: 768px) {
         .whatsapp-icon {
          bottom: 20px;
         left: 20px;
         }
         }
         /* Style for the Brands Section */
        .brands-section {
         text-align: center;
         padding: 50px 20px; /* Add space around the section */
         background-color: #f9f9f9;  /* Light background color */
        }

        .brands-section h2 {
        font-size: 2rem;
        color: #333;
        margin-bottom: 30px;
        }

        /* Grid Layout for Brand Logos */
       .brands-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Create 4 equal-width columns */
        gap: 30px; /* Space between logos */
        justify-items: center;  /* Center logos horizontally */
        align-items: center;    /* Center logos vertically */
       }

       /* Style for each brand logo */
       .brand-logo img {
        max-width: 100%;  /* Ensure the images are responsive */
        max-height: 80px; /* Adjust the max height of the logos */
        object-fit: contain;  /* Maintain aspect ratio */
      }

       /* Responsive adjustments for smaller screens */
       @media (max-width: 1024px) {
      .brands-container {
        grid-template-columns: repeat(3, 1fr); /* 3 columns for tablets */
       }
     }

       @media (max-width: 768px) {
      .brands-container {
        grid-template-columns: repeat(2, 1fr); /* 2 columns for mobile */
      }
     }

      @media (max-width: 480px) {
      .brands-container {
        grid-template-columns: 1fr; /* 1 column for very small screens */
      }
     }

    </style>
</head>
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <!-- About us -->
    <section class="about-section">
        <div class="about-container">
            <h2 class="about-title">Willkommen bei Vrooom</h2>
            <p class="about-text">
                Mobilität bedeutet Freiheit – und bei <strong>Vrooom</strong> stehen Sie immer an erster Stelle.  
                Wir bieten Ihnen moderne Fahrzeuge, flexible Mietoptionen und eine unkomplizierte Buchung –  
                alles, was Sie brauchen, um schnell und stilvoll unterwegs zu sein.
            </p>

            <ul class="about-list">
                <li>Große Auswahl – vom Cityflitzer bis zur Luxuslimousine.</li>
                <li>Flexible Mietzeiten – stundenweise, täglich oder langfristig.</li>
                <li>Transparente Preise – keine versteckten Kosten, keine Überraschungen.</li>
                <li>Einfache Buchung – in wenigen Klicks zum Traumauto.</li>
            </ul>

            <a href="booking.php" class="cta-button">Jetzt Auto mieten</a>
        </div>
    </section>


<!-- About us (Welches Auto passt zu Ihnen?) --> 
<section id="about-content" class="about-us-section">
    
        <div class="about-content">
        <h2>Welches Auto passt zu Ihnen?</h2>
    <p>Nicht sicher, welches Fahrzeug das richtige für Ihre Pläne ist?</p>
    <p> Hier ist eine schnelle Übersicht:</p>
    
    <p>🚗 <strong>Kompakt & sparsam</strong>  ➜ Perfekt für Städtereisen & kurze Strecken.</p>
    <p>🚙 <strong>SUV & Geländewagen</strong> ➜ Ideal für Familien, Abenteuer & lange Fahrten.</p>
    <p>🚘 <strong>Limousine & Premium</strong> ➜ Stilvoll & luxuriös für Geschäftsreisen & besondere Anlässe.</p>
    <p>⚡ <strong>Elektro & Hybrid</strong> ➜ Umweltfreundlich & modern unterwegs.</p>
    <br></br>

    <p>💡 <strong>Tipp:</strong> Nutzen Sie unsere Filteroptionen, um das passende Auto für Ihre Bedürfnisse zu finden!</p>
            
            <button class="cta-button" style="color: white;">

                Jetzt Fahrzeuge entdecken
            </button>
        </div>
        <div class="about-image">
            <img src="assets/Pic-carrental1.jpg" alt="Car Rental Image">
    </div>
</section>
</body>
</html>

<!-- Statistics -->
<section class="stats-section">
    <h2 class="stats-title">Warum Vrooom?</h2>
    <div class="stats-container">
        <div class="stat-box">
            <h3 class="stat-number"><span class="stat-value" data-count="50000">0</span></h3>
            <p>Fahrzeuge vermietet</p>
        </div>
        <div class="stat-box">
            <h3 class="stat-number"><span class="stat-value" data-count="98">0</span>%</h3>
            <p>Kundenzufriedenheit</p>
        </div>
    </div>
</section>

<style>
    .stats-section {
        text-align: center;
        padding: 50px 20px;
        background: linear-gradient(135deg, #222, #111); /* Hintergrund angepasst */
        color: white;
    }

    .stats-title {
        font-size: 2rem;
        color:rgb(251, 248, 247);
        margin-bottom: 20px;
    }

    .stats-container {
        display: flex;
        justify-content: center;
        gap: 50px;
    }

    .stat-box {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        width: 200px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #e50914;
    }

    .stat-box p {
        font-size: 1.1rem;
        color: white;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let stats = document.querySelectorAll(".stat-value");
        stats.forEach(stat => {
            let count = 0;
            let target = parseInt(stat.getAttribute("data-count"));
            let increment = target / 100;

            let updateCount = () => {
                count += increment;
                if (count < target) {
                    stat.innerText = Math.ceil(count);
                    requestAnimationFrame(updateCount);
                } else {
                    stat.innerText = target;
                }
            };
            updateCount();
        });
    });
</script>


</body>
</html>

    <!-- Review Section -->
    <div class="review-section" style="background-image: url('assets/roadtrip.jpg');">
        <h2>Kundenrezensionen</h2>
        <div class="review-carousel" id="reviews">
            <div class="review-item">"Toller Service! Sehr zufrieden." - Max M.</div>
            <div class="review-item">"Die Buchung war super einfach." - Lisa S.</div>
            <div class="review-item">"Gute Preise und freundlicher Support." - Kevin H.</div>
            <div class="review-item">"Alles top! Werde wieder buchen." - Sarah W.</div>
            <div class="review-item">"Riesige Auswahl an Fahrzeugen." - Tim L.</div>
            <div class="review-item">"Sehr empfehlenswert!" - Anna B.</div>
            <div class="review-item">"Hervorragende Erfahrung!" - Jonas F.</div>
        </div>
    </div>

    <!-- JavaScript for Review Carousel -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const carousel = document.getElementById("reviews");
            const items = carousel.querySelectorAll('.review-item');
            const itemWidth = items[0].offsetWidth + 20; // Include margin

            // Clone items and append them to the carousel for seamless looping
            items.forEach(item => {
                const clone = item.cloneNode(true);
                carousel.appendChild(clone);
            });

            function autoScroll() {
                if (carousel.scrollLeft >= carousel.scrollWidth / 2) {
                    carousel.scrollTo({ left: 0, behavior: 'auto' });
                } else {
                    carousel.scrollBy({ left: 10, behavior: 'smooth' });
                }
            }

            setInterval(autoScroll, 10); // Adjust the interval for smoother scrolling
        });
    </script>

    <?php
    // Include the footer file (footer.php)
    include("Footer.php");
    ?>

    <!-- WhatsApp Contact Icon (Place it at the end of the body) -->
 <a href="https://wa.me/393515567197" target="_blank" class="whatsapp-icon">
        <i class="fab fa-whatsapp"></i>
        
    </a>

</body>
</html>
