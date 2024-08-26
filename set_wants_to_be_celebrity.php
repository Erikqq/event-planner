<?php
require("db_config.php");
include("auth_session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];


    if (isset($_POST['set-celebrity'])) {

        $updateQuery = "UPDATE users SET wants_to_be_celebrity = 1 WHERE username = '$username'";
        if (mysqli_query($con, $updateQuery)) {
            header("Location: profile.php");
            exit();
        } else {
            echo "Hiba történt a kérelem beállításakor.";
        }
    } elseif (isset($_POST['unset-celebrity'])) {

        $updateQuery = "UPDATE users SET wants_to_be_celebrity = 0 WHERE username = '$username'";
        if (mysqli_query($con, $updateQuery)) {
            header("Location: profile.php");
            exit();
        } else {
            echo "Hiba történt a lejelentkezés beállításakor.";
        }
    }
}
?>
