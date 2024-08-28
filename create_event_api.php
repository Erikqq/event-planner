<?php
require("db_config.php");

// Set content type to JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data
    $input = json_decode(file_get_contents('php://input'), true);

    $name = mysqli_real_escape_string($con, $input['name']);
    $eventDate = mysqli_real_escape_string($con, $input['event_date']);
    $place = mysqli_real_escape_string($con, $input['place']);
    $type = mysqli_real_escape_string($con, $input['type']);
    $comment = mysqli_real_escape_string($con, $input['comment']);

    // Query to insert a new event
    $query = "INSERT INTO events (name, event_date, place, type, comment) 
              VALUES ('$name', '$eventDate', '$place', '$type', '$comment')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Event successfully created.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error occurred while creating the event.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
