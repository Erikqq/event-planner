<?php
require("db_config.php");

if (isset($_GET['code'])) {
    $verification_code = mysqli_real_escape_string($con, $_GET['code']);

    $query = "UPDATE users SET email_verified = 1 WHERE verification_code = '$verification_code'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_affected_rows($con) > 0) {
        echo "Email megerősítése sikeres! Most már bejelentkezhetsz.";
    } else {
        echo "Hibás vagy már használt megerősítő kód.";
    }
} else {
    echo "Nincs megadva megerősítő kód.";
}

header("Location: login.php");
?>
