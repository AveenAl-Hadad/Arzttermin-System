<?php
session_start();
include "verbindung.php";

$meldung = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rolle = $_POST['rolle'];  // "arzt" oder "patient"
    $passwort = password_hash($_POST['passwort'], PASSWORD_DEFAULT);

    // Überprüfen ob die E-Mail schon existiert
    $check = "SELECT * FROM benutzer WHERE email='$email'";
    $res = $conn->query($check);

    if ($res->num_rows > 0) {
        $meldung = "❌ Diese E-Mail ist bereits registriert.";
    } else {
        $sql = "INSERT INTO benutzer (name, email, rolle, passwort) VALUES ('$name', '$email', '$rolle', '$passwort')";
        if ($conn->query($sql)) {
            $meldung = "✅ Registrierung erfolgreich. Sie können sich jetzt <a href='login.php'>einloggen</a>.";
        } else {
            $meldung = "❌ Fehler bei der Registrierung: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung – Arzttermin-App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f7f7;
        }
        .register-box {
            margin-top: 100px;
        }
    </style>
</head>
<body>

<div class="container register-box">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">📝 Registrierung</h3>

                    <?php if (!empty($meldung)): ?>
                        <div class="alert alert-info"><?= $meldung ?></div>
                    <?php endif; ?>

                    <form method="POST" action="register.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Ihr Name</label>
                            <input type="text" class="form-control" id="name" name="name" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail-Adresse</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="rolle" class="form-label">Rolle</label>
                            <select class="form-select" id="rolle" name="rolle" required>
                                <option value="patient">Patient</option>
                                <option value="arzt">Arzt</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="passwort" class="form-label">Passwort</label>
                            <input type="password" class="form-control" id="passwort" name="passwort" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Registrieren</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        Bereits registriert? <a href="login.php">Jetzt einloggen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
