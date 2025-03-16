<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vrooom</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Styling */
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

        /* Background effect */
        .background {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('assets/bg-pattern.jpg') no-repeat center center/cover;
            filter: blur(8px);
            z-index: -1;
        }

        /* Login Container */
        .login-container {
            background: rgba(255, 255, 255, 0.36);
            backdrop-filter: blur(15px);
            padding: 50px; /* More space in container */
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 500px; /* wider */
            text-align: center;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-container:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        h1 {
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 25px;
        }

        /* Eingabefelder */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 18px; /* More space */
        }

        label {
            font-weight: 400;
            text-align: left;
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        .login-input {
            padding: 15px; 
            font-size: 1.1rem;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
            transition: 0.3s ease;
        }

        .login-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .login-input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        /* Login Button */
        .login-btn {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
            padding: 15px; /* bigger Button */
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255, 75, 43, 0.4);
        }


        .register-link {
            margin-top: 18px;
            font-size: 1rem;
        }

        .register-link a {
            color: #ff416c;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #ff4b2b;
            text-decoration: underline;
        }

        /* error message */
        .error-message {
            color: #ff4b2b;
            background: rgba(255, 75, 43, 0.2);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Responsiveness */
        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                padding: 40px;
            }
        }
    </style>
</head>
<body>

    <div class="background"></div> <!-- Hintergrund-Effekt -->
    
    <!-- Login Container -->
    <div class="login-container">
        <h1>Anmeldung</h1>

        <!-- Fehlermeldungen anzeigen -->
        <?php if (isset($_GET['error'])): ?>
            <p class="error-message">
                <?php
                if ($_GET['error'] == "wrongpassword") {
                    echo "Falsches Passwort. Bitte versuche es erneut.";
                } elseif ($_GET['error'] == "usernotfound") {
                    echo "Kein Konto mit dieser E-Mail gefunden.";
                }
                ?>
            </p>
        <?php endif; ?>

        <!-- Login Formular -->
        <form class="login-form" action="process_login.php" method="POST">
            <label for="email">E-Mail-Adresse</label>
            <input type="email" id="email" name="email" class="login-input" placeholder="Geben Sie Ihre E-Mail ein" required>

            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" class="login-input" placeholder="Geben Sie Ihr Passwort ein" required>

            <button type="submit" class="login-btn">Anmelden</button>
        </form>
        
        <!-- Registration-Link -->
        <div class="register-link">
            <p>Noch kein Konto? <a href="register.php">Registrieren</a></p>
        </div>
    </div>

</body>
</html>