<?php
require("db_config.php");

// Set content type to JSON
header('Content-Type: application/json');

// Query to get all events
$query = "SELECT * FROM events";
$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Hiba történt az események lekérésekor.']);
    exit();
}

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}

echo json_encode(['success' => true, 'events' => $events]);
?>
