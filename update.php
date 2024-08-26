<?php
require("db_config.php");

session_start();
if (!isset($_SESSION['username'])) {

    header("Location: login.php");
    exit();
}


if (isset($_POST['change-email'])) {

    $username = $_SESSION['username'];
    $newEmail = $_POST['new-email'];


    $updateQuery = "UPDATE users SET email = '$newEmail' WHERE username = '$username'";

    if (mysqli_query($con, $updateQuery)) {

        echo "Az email cím sikeresen meg lett változtatva.";

    } else {

        echo "Hiba történt az email cím módosítása során.";
    }
}



if (isset($_POST['change-description'])) {
    $username = $_SESSION['username'];
    $newDescription = $_POST['new-description'];
    $updateDescriptionQuery = "UPDATE users SET description = '$newDescription' WHERE username = '$username'";

    if (mysqli_query($con, $updateDescriptionQuery)) {
        echo "A leírás sikeresen meg lett változtatva.";

    } else {
        echo "Hiba történt a leírás módosítása során.";
    }
}

header("Location: profile.php");
?>
