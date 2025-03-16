<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        /* Global styles */
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

        /* Registration container */
        .register-container {
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

        .register-container:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        h1 {
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 25px;
        }

        /* Form styling */
        .register-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group {
            width: 100%;
            text-align: left;
            margin-bottom: 18px;
        }

        label {
            font-weight: 400;
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            display: block;
            margin-bottom: 5px;
        }

        /* Input field styling */
        .register-input {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
            transition: 0.3s ease;
            display: block;
        }

        .register-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .register-input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        /* Register button */
        .register-btn {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .register-btn:hover {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255, 75, 43, 0.4);
        }

        /* Login link */
        .login-link {
            margin-top: 18px;
            font-size: 1rem;
        }

        .login-link a {
            color: #ff416c;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #ff4b2b;
            text-decoration: underline;
        }

        /* Error message */
        .error-message {
            color: #ff4b2b;
            background: rgba(255, 75, 43, 0.2);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Responsiveness */
        @media (max-width: 480px) {
            .register-container {
                width: 90%;
                padding: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="background"></div>

    <!-- Registration container -->
    <div class="register-container">
        <h1>Registrierung</h1>

        <!-- Registration form -->
        <form action="register_process.php" method="POST" class="register-form">

            <!-- First name -->
            <div class="form-group">
                <label for="first-name">Vorname</label>
                <input type="text" id="first-name" name="first_name" class="register-input" required>
            </div>

            <!-- Last name -->
            <div class="form-group">
                <label for="last-name">Nachname</label>
                <input type="text" id="last-name" name="last_name" class="register-input" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email-Adresse</label>
                <input type="email" id="email" name="email" class="register-input" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" class="register-input" required>
            </div>

            <!-- Confirm password -->
            <div class="form-group">
                <label for="confirm-password">Password bestätigen</label>
                <input type="password" id="confirm-password" name="confirm_password" class="register-input" required>
            </div>

            <!-- Register button -->
            <button type="submit" class="register-btn">Registrieren</button>
        </form>

        <!-- Link to login -->
        <p class="login-link">Haben Sie bereits einen Account? <a href="login.php">Anmelden</a></p>
    </div>
</body>
</html>