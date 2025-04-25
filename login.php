<?php
session_start();
include "verbindung.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $pw = $_POST['passwort'];

    $sql = "SELECT * FROM benutzer WHERE email='$email'";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        echo $row['anrede']; // Vorübergehend zur Überprüfung

        if (password_verify($pw, $row['passwort'])) {
            $_SESSION['userid'] = $row['id'];
            $_SESSION['rolle'] = $row['rolle'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['anrede'] = $row['anrede']; 
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "❌ Falsches Passwort.";
        }
    } else {
        $error = "❌ Benutzer nicht gefunden.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login – Arzttermin-App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f7f7;
        }
        .login-box {
            margin-top: 100px;
        }
    </style>
</head>
<body>

<div class="container login-box">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">🔐 Login</h3>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" action="login.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail-Adresse</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="passwort" class="form-label">Passwort</label>
                            <input type="password" class="form-control" id="passwort" name="passwort" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Einloggen</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        Noch kein Konto? <a href="register.php">Jetzt registrieren</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
