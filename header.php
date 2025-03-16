<?php
session_start(); // Start session to store user data

// Get logged-in username
$loggedInUser = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
        /* Global styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f8f8f8;
        }

        /* Header container */
        .header {
            background: white;
            width: 100%;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid rgb(255, 0, 43);
        }

        /* Logo */
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: rgb(255, 0, 43);
        }

        /* Navigation menu */
        .nav-menu {
            display: flex;
            gap: 25px;
        }

        .nav-menu a {
            color: #333;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-menu a:hover {
            background-color: rgba(255, 0, 43, 0.1);
        }

    

        /* User info */
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1rem;
            font-weight: bold;
        }

        /* Logout button */
        .logout-btn {
            background: rgb(255, 0, 43);
            color: white;
            padding: 8px 12px;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .logout-btn:hover {
            background: rgb(200, 0, 35);
        }

        /* Login link */
        .login-link {
            text-decoration: none;
            color: rgb(255, 0, 43);
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .login-link:hover {
            background-color: rgba(255, 0, 43, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .nav-menu {
                flex-direction: column;
                gap: 10px;
            }

            .user-info {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header container -->
    <header class="header">
        <div class="logo">Vrooom</div>
        
        <!-- Navigation menu -->
        <nav class="nav-menu">
            <a href="booking.php">Meine Buchungen</a>
            <a href="contact.php">Kontakt</a>
            <!-- Detail Search Button -->
            <a href="productoverview.php" class="detail-search-btn">Detailsuche</a>
        </nav>

        <!-- User info -->
        <div class="user-info">
            <?php if ($username): ?>
                <!-- Display username if logged in -->
                Hello, <a href="booking.php" style="color: rgb(255, 0, 43); text-decoration: none; font-weight: bold;">
                    <?php echo htmlspecialchars($username); ?>
                </a>

                <!-- Logout button -->
                <form action="logout.php" method="POST" style="display: inline;">
                    <button type="submit" class="logout-btn">Abmelden</button>
                </form>
                
            <?php else: ?>
                <!-- Display login link if not logged in -->
                <a href="login.php" class="login-link">Anmelden</a>
            <?php endif; ?>
        </div>
    </header>
</body>
</html>
