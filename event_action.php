<?php
include("auth_session.php");
require("db_config.php");

// Get POST data
$event_id = $_POST['event_id'];
$action = $_POST['action'];

// Get user_id from session
$user_id = $_SESSION['user_id']; // Assuming 'user_id' is stored in session

if ($action === 'RSVP') {
    // Insert into event_invitations
    $insertQuery = "INSERT INTO event_invitations (event_id, invitee_id, user_id, bring_item, status, created_at) 
                    VALUES ('$event_id', '$user_id', '$user_id', '', 'Jövök', NOW())";
    if (mysqli_query($con, $insertQuery)) {
        echo "RSVP successful.";
    } else {
        echo "Error inserting RSVP: " . mysqli_error($con);
    }
} elseif ($action === 'Cancel') {
    // Delete from event_invitations
    $deleteQuery = "DELETE FROM event_invitations WHERE event_id='$event_id' AND user_id='$user_id'";
    if (mysqli_query($con, $deleteQuery)) {
        echo "RSVP cancelled.";
    } else {
        echo "Error cancelling RSVP: " . mysqli_error($con);
    }
} else {
    echo "Invalid action.";
}

mysqli_close($con);
?>
