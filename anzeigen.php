<?php
session_start();
include "verbindung.php";

// Nur für eingeloggte Benutzer
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM termine ORDER BY datum ASC, uhrzeit ASC";
$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Terminübersicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .termin-box {
            margin-top: 50px;
        }
        .table thead {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>

<div class="container termin-box">
    <h2 class="text-center mb-4">🗓 Alle gebuchten Arzttermine</h2>

    <div class="mb-3">
        <a href="dashboard.php" class="btn btn-secondary">⬅️ Zurück zum Startseite</a>
    </div>

    <?php if ($res->num_rows > 0): ?>
        <table class="table table-striped table-hover shadow">
            <thead>
                <tr>
                    <th>Anzal</th>
                    <th>Patient</th>
                    <th>E_Mail</th>
                    <th>Datum</th>
                    <th>Uhrzeit</th>
                    <th>Grund</th>
                </tr>
            </thead>
            <tbody>
                <?php $nr = 1; while ($row = $res->fetch_assoc()): 
                    // Datum und Uhrzeit formatieren
                    $formatted_date = date("d.m.Y", strtotime($row['datum']));  // Datum im Format Tag.Monat.Jahr
                    $formatted_time = date("H:i", strtotime($row['uhrzeit']));   // Uhrzeit im Format Stunden:Minuten
                ?>
                    <tr>
                        <td><?= $nr++ ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= $formatted_date?></td>
                        <td><?= $formatted_time ?></td>
                        <td><?= htmlspecialchars($row['grund']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Es sind noch keine Termine vorhanden.</div>
    <?php endif; ?>
</div>

</body>
</html>
