<?php
include "verbindung.php";

$sql = "SELECT * FROM termine ORDER BY datum, uhrzeit";
$result = $conn->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'anrede' => $row['anrede'],
        'title' => $row['name'] . " – " . $row['grund'],
        'start' => $row['datum'] . 'T' . $row['uhrzeit'],
        'email' => $row['email'] 
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
