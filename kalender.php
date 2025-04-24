<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['rolle'] !== 'arzt') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Termin-Kalender</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.js'></script>
    <style>
        #kalender {
            max-width: 900px;
            margin: 40px auto;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">📅 Kalenderübersicht aller Termine</h2>
    <div id="kalender"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('kalender');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            locale: 'de',
            events: 'termine_json.php' // ✅ Ruft PHP separat ab
        });
        calendar.render();
    });
    </script>
</body>
</html>
