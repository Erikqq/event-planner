<?php
require('db_config.php');
require("auth_session.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['event_id'];
    $inviteeName = mysqli_real_escape_string($con, $_POST['invitee_name']);
    $bringItem = mysqli_real_escape_string($con, $_POST['bring_item']);

    $query = "INSERT INTO invitations (event_id, invitee_name, bring_item) 
              VALUES ('$eventId', '$inviteeName', '$bringItem')";

    if (mysqli_query($con, $query)) {
        echo "Meghívó sikeresen elküldve.";
        // Redirect back to the events page or wherever you want
        header("Location: profile.php");
        exit();
    } else {
        echo "Hiba történt a meghívás során: " . mysqli_error($con);
    }
} else {
    echo "Helytelen kérés.";
}
?>
