<?php
include 'db_config.php';
include 'auth_session.php';

// Ellenőrizzük, hogy a formot POST módszerrel küldték-e
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_event'])) {
    // Adatok lekérése a formból
    $eventId = $_POST['event_id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $eventDate = $_POST['event_date']; // datetime-local formátumban
    $place = mysqli_real_escape_string($con, $_POST['place']);
    $type = mysqli_real_escape_string($con, $_POST['type']);

    // SQL lekérdezés az esemény frissítésére
    $updateQuery = "
        UPDATE events
        SET name = '$name', event_date = '$eventDate', place = '$place', type = '$type'
        WHERE id = '$eventId'
    ";

    // Lekérdezés végrehajtása
    if (mysqli_query($con, $updateQuery)) {
        echo "<p>Esemény sikeresen módosítva.</p>";
    } else {
        echo "<p>Hiba történt az esemény módosítása során: " . mysqli_error($con) . "</p>";
    }
} else {
    echo "<p>Nem érvényes kérés.</p>";
}

header("Location: manage_events.php");
?>
