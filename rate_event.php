<?php
session_start();
require 'db_config.php';
require 'auth_session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $rating = $_POST['rating'];
    $username = $_SESSION['username'];

    // Felhasználó azonosító lekérdezése
    $userQuery = "SELECT id FROM users WHERE username = '$username'";
    $userResult = mysqli_query($con, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $user_id = $userData['id'];

    // Értékelés mentése
    $insertRatingQuery = "
        INSERT INTO event_ratings (event_id, user_id, rating)
        VALUES ('$event_id', '$user_id', '$rating')
        ON DUPLICATE KEY UPDATE rating = VALUES(rating)
    ";
    $insertRatingResult = mysqli_query($con, $insertRatingQuery);

    if ($insertRatingResult) {
        $_SESSION['message'] = "Értékelés sikeresen elküldve.";
    } else {
        $_SESSION['message'] = "Hiba történt az értékelés küldésekor.";
    }

    header("Location: profile.php");
    exit();
}
?>
