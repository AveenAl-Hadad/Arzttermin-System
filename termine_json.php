<?php
include "verbindung.php";
$result = $conn->query("SELECT * FROM termine");
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['name'],
        'start' => $row['datum'] . "T" . $row['uhrzeit']
    ];
}
echo json_encode($events);
?>