<?php
include("auth_session.php");
require("db_config.php");

// Get POST data
$event_id = $_POST['event_id'];
$user_id = $_SESSION['user_id']; // Assuming 'user_id' is stored in session

// Insert into event_invitations
$insertQuery = "INSERT INTO event_invitations (event_id, invitee_id, user_id, bring_item, status, created_at) 
                VALUES ('$event_id', '$user_id', '$user_id', '', 'Jövök', NOW())";

if (mysqli_query($con, $insertQuery)) {
    echo "RSVP successful.";
} else {
    echo "Error inserting RSVP: " . mysqli_error($con);
}

mysqli_close($con);
?>
