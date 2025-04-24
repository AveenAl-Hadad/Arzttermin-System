<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arzttermin-System</title>
    
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        header {
            background-color: #0066cc;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        h1 {
            font-size: 2em;
            margin: 0;
        }

        nav {
            text-align: center;
            margin-top: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #0066cc;
            font-size: 1.2em;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #e2e2e2;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #0066cc;
            color: white;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <header>
        <h1>Willkommen beim Arzttermin-System-Online buchen</h1>
    </header>

    <div class="container">
        <nav>
            <ul>
                <?php if (!isset($_SESSION['userid'])): ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Registrieren</a></li>
                    <li><a href="termine.php">Termin buchen</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <footer>
        <p>&copy; 2025 Arzttermin-System. Alle Rechte vorbehalten.</p>
    </footer>

</body>
</html>
