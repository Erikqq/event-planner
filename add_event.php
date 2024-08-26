<?php
require("db_config.php");
include("auth_session.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['date']) && isset($_POST['place']) && isset($_POST['type'])) {
        $name = $_POST['name'];
        $date = $_POST['date'];
        $place = $_POST['place'];
        $type = $_POST['type'];
        $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
        $username = $_SESSION['username'];

        $userQuery = "SELECT id FROM users WHERE username = '$username'";
        $userResult = mysqli_query($con, $userQuery);
        $userData = mysqli_fetch_assoc($userResult);
        $user_id = $userData['id'];

        $insertQuery = "INSERT INTO events (user_id, name, event_date, place, type, comment) VALUES ('$user_id', '$name', '$date', '$place', '$type', '$comment')";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            $message = "Az esemény sikeresen hozzáadva lett.";
        } else {
            $message = "Hiba történt az esemény hozzáadásakor.";
        }

        header("Location: profile.php");
        exit();
    }
}
?>
