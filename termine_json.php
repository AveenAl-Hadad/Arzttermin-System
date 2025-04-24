<?php
include "verbindung.php";

$sql = "SELECT * FROM termine ORDER BY datum, uhrzeit";
$result = $conn->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['name'] . " – " . $row['grund'],
        'start' => $row['datum'] . 'T' . $row['uhrzeit']
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
