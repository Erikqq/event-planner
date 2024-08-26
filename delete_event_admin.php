<?php
 
include 'db_config.php';
require("auth_session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_event'])) {

    $eventId = $_POST['event_id'];

    $deleteQuery = "DELETE FROM events WHERE id = '$eventId'";

    if (mysqli_query($con, $deleteQuery)) {
        echo "<p>Esemény sikeresen törölve.</p>";
    } else {
        echo "<p>Hiba történt az esemény törlése során: " . mysqli_error($con) . "</p>";
    }
} else {
    echo "<p>Nem érvényes kérés.</p>";
}

header("Location: manage_events.php");
?>
