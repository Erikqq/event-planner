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

    // Query to delete the event
    $query = "DELETE FROM events WHERE id='$eventId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Event successfully deleted.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error occurred while deleting the event.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
