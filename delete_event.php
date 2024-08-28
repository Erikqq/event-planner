<?php
require("db_config.php");


if (isset($_POST['delete-event'])) {

    session_start();
    if (!isset($_SESSION['username'])) {

        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['username'];
    $eventId = $_POST['delete-event-id'];


    $eventQuery = "SELECT * FROM events WHERE id = $eventId AND user_id IN (SELECT id FROM users WHERE username = '$username')";
    $eventResult = mysqli_query($con, $eventQuery);

    if (mysqli_num_rows($eventResult) > 0) {

        $deleteQuery = "DELETE FROM events WHERE id = $eventId";
        if (mysqli_query($con, $deleteQuery)) {

            echo "Az esemény sikeresen törölve lett.";
        } else {

            echo "Hiba történt a törlés során.";
        }
    } else {

        echo "Nincs jogosultságod törölni ezt az eseményt.";
    }
    header("Location: profile.php");
}
?>
