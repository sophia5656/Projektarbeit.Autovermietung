
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoverleih Footer</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        /* Background color of whole Footer*/
        .footer {
            background-color:rgb(28, 31, 34);
            color: #fff;
            padding: 40px 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap:wrap;  /* all info or buttons show up in column*/ 
            
        }

      /* Change color for "Alle Rechte vorbehalten" */
.footer-bottom p {
    background-color:rgb(240, 243, 247);
    color: black;      
    padding: 20px 0;
    text-align: center;
}
    .footer-bottom a {
        color: Black; /* Set your desired color for the links (Impressum, AGB, ..)*/
        text-decoration: none;
}
        .footer .footer-column {
    flex: 1;
    margin: 0 20px; /* Space between columns */
}

.footer .footer-column h3 {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
}

.footer .footer-column ul {
    list-style-type: none; /* Remove bullet points */
    padding: 0;
}

.footer .footer-column ul li {
    margin-bottom: 8px;
}

.footer .footer-column ul li a {
    color: #333;              /*color of Text in Column in Footer*/
    text-decoration: none;
    font-size: 14px;
}

.footer .footer-column ul li a:hover {
    color:rgb(244, 241, 233); /* Gold color on hover */

}
        .app-buttons img {    /* Adjust size of download options here */
            height: 30px;
            margin-left: 10px;
            margin-right: 10px;

            
        }
  /* Margin size for Footer "Alle rechte Vorbeihalten"*/
        .footer p {
            
            margin: 10px 0 0;
            font-size: 12px;
           
        }
  /* Space between social media icons */
        .social-icons img {
            width: 20px;
            height: 20px;
            margin: 10px;
        }
    
    </style>
</head>
<body>
    <section>
    <footer class="footer-bottom">
        <div class="social-icons">
                <a href="https://www.facebook.com/" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/Facebook_icon.svg" alt="Facebook">
                </a>
                <a href="https://www.instagram.com/" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram">
                </a>
                <a href="https://www.linkedin.com/" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Linkedin_icon.svg" alt="LinkedIn">
                </a>
            </div>
<footer class="footer">
    <!-- Column 1: Unsere Mietwagen -->
    <div class="footer-column">
        <h3>Kundenservice</h3>
        <ul>
            <li><a href="#">OS-Plattform</a></li>
            <li><a href="#">Hilfe - Fragen und Antworten</a></li>
            <li><a href="#">Debit Karten Informationen</a></li>
            <li><a href="#">Flottenübersicht</a></li>
            <li><a href="#">Stationen</a></li>
            <li><a href="#">Rechnungskopie</a></li>
        </ul>
    </div>

    <!-- Column 2: Unsere Mietwagen -->
    <div class="footer-column">
        <h3>Business center</h3>
        <ul>
            <li><a href="#">Kunde werden</a></li>
            <li><a href="#">Firmenkunden</a></li>
            <li><a href="#">Reisebüros</a></li>
            <li><a href="#">Replacement</a></li>
            <li><a href="#">Reservieren</a></li>
            
        </ul>
    </div>

    <!-- Column 3: Im Überblick -->
    <div class="footer-column">
        <h3>Im Überblick</h3>
        <ul>
            <li><a href="#">Mietinformationen</a></li>
            <li><a href="#">Cookie Settings</a></li>
            <li><a href="#">Nutzungsbedingungen</a></li>
            <li><a href="#">Rückgabebedingungen</a></li>
            <li><a href="#">Versicherungsoptionen</a></li>
        </ul>
    </div>

    <!-- Column 4: Über uns -->
    <div class="footer-column">
        <h3>Über uns</h3>
        <ul>
            <li><a href="#">Unternehmen</a></li>
            <li><a href="#">Magazin</a></li>
            <li><a href="contact.php">Kontakt</a></li>
        </ul>
    </div>

    
     <!-- Footer Bottom Section for Download Icons -->
        <div class="app-buttons">
            <a href="https://www.apple.com/app-store/" target="_blank">
                <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="Download on the App Store">
            </a>
            <a href="https://play.google.com/store" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play">
            </a>
        </div>
    
    </footer>
    </div>
    
    </footer>

            <footer class="footer-bottom">
                 <div class="footer-links">
        <p>
        <span>&copy; <?php echo date("Y"); ?> Vrooom. Alle Rechte vorbehalten.</span>
            <a href="impressum.php">Impressum</a> | 
            <a href="daten.php">Datenschutz</a> | 
            <a href="agb.php">AGB </a> | 
        </p>
       
</section>
</body>
</html>
