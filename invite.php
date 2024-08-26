<?php
session_start();
require 'db_config.php';  // Csatlakozás az adatbázishoz
require 'auth_session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $invitee_name = $_POST['invitee_name'];
    $bring_item = $_POST['bring_item'];

    // Ellenőrizzük, hogy létezik-e a meghívott felhasználó
    $userQuery = "SELECT id FROM users WHERE username = '$invitee_name'";
    $userResult = mysqli_query($con, $userQuery);

    if (mysqli_num_rows($userResult) > 0) {
        $userData = mysqli_fetch_assoc($userResult);
        $invitee_id = $userData['id'];

        // Meghívás elmentése az adatbázisba
        $inviteQuery = "INSERT INTO event_invitations (event_id, user_id, bring_item) VALUES ('$event_id', '$invitee_id', '$bring_item')";
        $inviteResult = mysqli_query($con, $inviteQuery);

        if ($inviteResult) {
            $message = "Meghívás sikeresen elküldve.";
        } else {
            $message = "Hiba történt a meghívás elküldésekor.";
        }
    } else {
        $message = "A megadott felhasználónév nem található.";
    }

    // Visszairányítás egy üzenettel
    $_SESSION['message'] = $message;
    header("Location: profile.php");  // Visszairányítás az események oldalára
    exit();
}
?>
