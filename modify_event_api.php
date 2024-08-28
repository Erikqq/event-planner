<?php
require("db_config.php");

// Set content type to JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id']) || empty($input['id'])) {
        echo json_encode(['success' => false, 'message' => 'Event ID is required.']);
        exit();
    }

    $eventId = mysqli_real_escape_string($con, $input['id']);
    $name = mysqli_real_escape_string($con, $input['name']);
    $eventDate = mysqli_real_escape_string($con, $input['event_date']);
    $place = mysqli_real_escape_string($con, $input['place']);
    $type = mysqli_real_escape_string($con, $input['type']);
    $comment = mysqli_real_escape_string($con, $input['comment']);

    // Query to update the event
    $query = "UPDATE events 
              SET name='$name', event_date='$eventDate', place='$place', type='$type', comment='$comment'
              WHERE id='$eventId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Event successfully updated.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error occurred while updating the event.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
