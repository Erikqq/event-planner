<?php

require("db_config.php");
include("auth_session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rate'])) {
    $walk_id = $_POST['walk_id'];
    $rating = $_POST['rating'];


    $walkerQuery = "SELECT walker_id FROM walks WHERE id = '$walk_id'";
    $walkerResult = mysqli_query($con, $walkerQuery);
    $walkerData = mysqli_fetch_assoc($walkerResult);
    $walker_id = $walkerData['walker_id'];


    $checkRatedQuery = "SELECT rated FROM walks WHERE id = '$walk_id'";
    $checkRatedResult = mysqli_query($con, $checkRatedQuery);
    $walkData = mysqli_fetch_assoc($checkRatedResult);

    if (!$walkData['rated']) {

        $updateRatedQuery = "UPDATE walks SET rated = 1 WHERE id = '$walk_id'";
        mysqli_query($con, $updateRatedQuery);


        $updateRatingQuery = "UPDATE users SET rating = '$rating', rates = rates + 1 WHERE id = '$walker_id'";
        mysqli_query($con, $updateRatingQuery);

        echo "Sikeresen értékelted a sétáltatást!";
    } else {
        echo "Ezt a sétáltatást már értékelted korábban.";
    }

	header("Location: profile.php");
}
?>
