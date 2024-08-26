<?php
require("db_config.php");
include("auth_session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['dog_id']) && isset($_POST['day']) && isset($_POST['message'])) {
        $dog_id = $_POST['dog_id'];
        $day = $_POST['day'];
        $message = $_POST['message'];
        $username = $_SESSION['username'];

        $userQuery = "SELECT id FROM users WHERE username = '$username'";
        $userResult = mysqli_query($con, $userQuery);
        $userData = mysqli_fetch_assoc($userResult);
        $user_id = $userData['id'];

        $insertQuery = "INSERT INTO walks (dog_id, user_id, day, message) 
                        VALUES ('$dog_id', '$user_id', '$day', '$message')";
        $insertResult = mysqli_query($con, $insertQuery);

        header("Location: profile.php");
        exit();
    }
}
?>