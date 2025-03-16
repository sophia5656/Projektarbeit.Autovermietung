<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
    <style>
        /* <General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e1e1e, #3a3a3a);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
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

        /* contact-container */
        .contact-container {
            background: rgba(255, 255, 255, 0.36);
            backdrop-filter: blur(15px);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 500px;
            text-align: center;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .contact-container:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        h1 {
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 25px;
        }

        /* textfields */
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        label {
            font-weight: 400;
            text-align: left;
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        .contact-input, .contact-textarea {
            padding: 15px;
            font-size: 1.1rem;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
            transition: 0.3s ease;
            width: 100%;
        }

        .contact-input::placeholder, .contact-textarea::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .contact-input:focus, .contact-textarea:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .contact-textarea {
            height: 120px;
            resize: none;
        }

        /* Send Button */
        .contact-btn {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .contact-btn:hover {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255, 75, 43, 0.4);
        }

        /* Contact Information */
        .contact-info {
            text-align: center;
            margin-top: 20px;
            font-size: 1rem;
        }

        .contact-info strong {
            color: #ff416c;
        }

        /* Responsiveness */
        @media (max-width: 480px) {
            .contact-container {
                width: 90%;
                padding: 40px;
            }
        }
    </style>
</head>
<body>
    <!-- background-effect -->
    <div class="background"></div> 

    <div class="contact-container">
        <h1>Kontakt</h1>

        <!-- Contact sheet-->
        <form class="contact-form" action="process_contact.php" method="POST">
            <label for="name">Ihr Name</label>
            <input type="text" id="name" name="name" class="contact-input" placeholder="Geben Sie Ihren Namen ein" required>

            <label for="email">Ihre E-Mail</label>
            <input type="email" id="email" name="email" class="contact-input" placeholder="Geben Sie Ihre E-Mail ein" required>

            <label for="message">Ihre Nachricht</label>
            <textarea id="message" name="message" class="contact-textarea" placeholder="Geben Sie Ihre Nachricht ein" required></textarea>

            <button type="submit" class="contact-btn">Nachricht senden</button>
        </form>

        <!-- Contact information-->
        <div class="contact-info">
            <p>Alternativ per E-Mail: <strong>kontakt@carsharing.de</strong></p>
            <p>Telefon: <strong>+49 123 456 789</strong></p>
        </div>
    </div>
</body>
</html>