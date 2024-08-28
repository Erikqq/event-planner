<?php
session_start();
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invite_id = $_POST['invite_id'];

    $deleteQuery = "DELETE FROM invitations WHERE id = '$invite_id'";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        $message = "Meghívás sikeresen törölve.";
    } else {
        $message = "Hiba történt a meghívás törlésekor.";
    }

    $_SESSION['message'] = $message;
    header("Location: profile.php");
    exit();
}
?>
