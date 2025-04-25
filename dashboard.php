<?php
session_start();

if (!isset($_SESSION['rolle'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerübersicht</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #0066cc;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        h2 {
            font-size: 1.8em;
            margin: 20px 0;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 1.1em;
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: #fff;
            background-color: #28a745;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #218838;
        }

        .arzt-link {
            background-color: #17a2b8;
        }

        .arzt-link:hover {
            background-color: #138496;
        }

        .logout-link {
            background-color: #dc3545;
        }

        .logout-link:hover {
            background-color: #c82333;
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
        <h1>Benutzerübersicht</h1>
    </header>

    <div class="container">
        <?php
            $rolle = $_SESSION['rolle'];
            $anrede = $_SESSION['anrede'];
            $name = $_SESSION['name'];
         
            if ($rolle === 'arzt') {
                echo "<h2>Willkommen, Dr. $anrede $name</h2>";
            } else {
                echo "<h2>Willkommen, $anrede $name</h2>";
            }
        ?>        

        <!-- 🟢 Nur Ärzte sehen diesen Link -->
        <?php if ($_SESSION['rolle'] === 'arzt'): ?>
            <p><a href="anzeigen.php" class="arzt-link">🗓 Alle Termine anzeigen</a></p><br>
            <p><a href="kalender.php" class="btn btn-outline-primary">📆 Kalender aller Termine</a></p><br>
            <p><a href="termine.php">➕ Termin buchen</a></p>
        <?php endif; ?>

        <!-- Für alle: Termin buchen -->
        <?php if ($_SESSION['rolle'] === 'patient'): ?>
            <p>
                <a href="termine.php">➕ Termin buchen</a>
            </p>
        <?php endif; ?>
<br>
        <!-- Logout-Link für alle -->
        <p><a href="logout.php" class="logout-link">🚪 Logout</a></p>
    </div>
    
    <footer>
        <p>&copy; 2025 Arzttermin-System. Alle Rechte vorbehalten.</p>
    </footer>

</body>
</html>

