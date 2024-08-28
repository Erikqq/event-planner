<?php
require('db_config.php');

if (isset($_POST['unblock_event'])) {
    $event_id = mysqli_real_escape_string($con, $_POST['event_id']);

    // Get the blocked event details
    $query = "SELECT * FROM blocked_events WHERE id = '$event_id'";
    $result = mysqli_query($con, $query);
    $event = mysqli_fetch_assoc($result);

    if ($event) {
        // Insert into events
        $query = "INSERT INTO events (user_id, name, event_date, place, type, comment, created_at)
                  VALUES ('{$event['user_id']}', '{$event['name']}', '{$event['event_date']}', '{$event['place']}', '{$event['type']}', '{$event['comment']}', '{$event['created_at']}')";
        mysqli_query($con, $query);

        // Delete from blocked_events
        $query = "DELETE FROM blocked_events WHERE id = '$event_id'";
        mysqli_query($con, $query);

        echo "<p>Esemény sikeresen engedélyezve.</p>";
    } else {
        echo "<p>Betiltott esemény nem található.</p>";
    }
} else {
    echo "<p>Nem érkezett esemény ID.</p>";
}
header("Location: manage_events.php");
?>
