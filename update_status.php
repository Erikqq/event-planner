<?php
session_start();
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invite_id = $_POST['invite_id'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE event_invitations SET status = '$status' WHERE id = '$invite_id'";
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        $message = "Státusz sikeresen frissítve.";
    } else {
        $message = "Hiba történt a státusz frissítésekor.";
    }

    $_SESSION['message'] = $message;
    header("Location: profile.php");
    exit();
}
?>
