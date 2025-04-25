<?php
session_start();
include "verbindung.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $anrede = $_POST['anrede'];
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $datum = $_POST['datum'];
    $uhrzeit = $_POST['uhrzeit'];
    $grund = $_POST['grund'];

    // Doppelte Termine verhindern
    $check = "SELECT * FROM termine WHERE datum='$datum' AND uhrzeit='$uhrzeit' AND email='$email'";
    $res = $conn->query($check);

    if ($res->num_rows > 0) {
        // Fehler: Termin belegt
        $_SESSION['buchung_error'] = "❌ Der Termin am $datum um $uhrzeit ist bereits vergeben.";
        header("Location: index.php");
        exit;
    }

    // Einfügen
    $sql = "INSERT INTO termine (anrede, name, email, datum, uhrzeit, grund) VALUES ('$anrede', '$name', '$email', '$datum', '$uhrzeit', '$grund')";
    if ($conn->query($sql)) {
        $formatted_date = date("d.m.Y", strtotime($datum));  // Formatierung des Datums
        $formatted_time = date("H:i", strtotime($uhrzeit));   // Formatierung der Uhrzeit

        // Erfolgsnachricht mit dem formatierten Datum und der Uhrzeit
        $_SESSION['buchung_erfolg'] = "✅ $anrede $name Termin erfolgreich gebucht für den <strong>$formatted_date</strong> um <strong>$formatted_time</strong>.";

       // $_SESSION['buchung_erfolg'] = "✅ $anrede $name Termin erfolgreich gebucht für den <strong>$datum</strong> um <strong>$uhrzeit</strong>.";
        
        // 📧 E-Mail vorbereiten
        $betreff = "🩺 Terminbestätigung – Ihr Arzttermin am $datum";
        $nachricht = "Hallo $name,\n\n".
                 "Sie haben erfolgreich einen Termin gebucht:\n\n".
                 "📅 Datum: $datum\n🕑 Uhrzeit: $uhrzeit\n📝 Grund: $grund\n\n".
                 "Vielen Dank für Ihre Buchung.\n\nIhre Arztpraxis";

        $headers = "From: praxis@example.com";

        // ✅ E-Mail senden (mail() funktioniert auf Webservern oder mit SMTP lokal)
        mail($email, $betreff, $nachricht, $headers);

    } else {
        $_SESSION['buchung_error'] = "❌ Fehler beim Buchen des Termins.";
    }
    
    header("Location: termine.php");
    exit;
    
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Arzttermin buchen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .termin-form {
            max-width: 600px;
            margin: 50px auto;
        }
    </style>
</head>
<body>

<div class="container termin-form">
    <h2 class="mb-4 text-center">🩺 Arzttermin buchen</h2>

    <!-- ✅ Erfolgs- oder Fehlermeldung anzeigen -->
    <?php if (isset($_SESSION['buchung_erfolg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['buchung_erfolg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Schließen"></button>
        </div>
        <?php unset($_SESSION['buchung_erfolg']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['buchung_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['buchung_error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Schließen"></button>
        </div>
        <?php unset($_SESSION['buchung_error']); ?>
    <?php endif; ?>

    <!-- ✅ Terminbuchungsformular -->
    <form action="termine.php" method="POST">
        <div class="mb-3">
            <label for="anrede" class="form-label">Anrede</label>
            <select class="form-select" id="anrede" name="anrede" required>
                <option value="">Bitte wählen</option>
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Ihr Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Ihre E-Mail-Adresse</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="mb-3">
            <label for="datum" class="form-label">Datum</label>
            <input type="date" class="form-control" name="datum" id="datum" required>
        </div>

        <div class="mb-3">
            <label for="uhrzeit" class="form-label">Uhrzeit</label>
            <input type="time" class="form-control" name="uhrzeit" id="uhrzeit" required>
        </div>

        <div class="mb-3">
            <label for="grund" class="form-label">Grund des Termins</label>
            <textarea name="grund" class="form-control" id="grund" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">✅ Termin buchen</button>
    </form>
    
            <?php if (!isset($_SESSION['userid'])): ?>
                <div class="mt-4 text-center">
                    <a href="index.php">Züruck zu Startseite<</a>
                </div>
            <?php else: ?>
                <div class="mt-4 text-center">
                    <a href="dashboard.php">Züruck zu Startseite</a>
                </div>
            <?php endif; ?>
       
    
</div>

</body>
</html>


