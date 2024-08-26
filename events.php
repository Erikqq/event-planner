<?php
session_start();
require 'db_config.php';


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

header('Content-Type: application/json');

// Fetch events
$query = "SELECT * FROM events";
$result = mysqli_query($con, $query);

$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}

// Return events as JSON
echo json_encode($events);


$username = $_SESSION['username'];
// Lekérdezzük a felhasználó admin szintjét
$userQuery = "SELECT id, adminLevel FROM users WHERE username = '$username'";
$userResult = mysqli_query($con, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$userId = $userData['id'];
$adminLevel = $userData['adminLevel'];

// Események lekérdezése
$eventsQuery = "SELECT * FROM events WHERE type = 'Publikus'";

// Ha admin a felhasználó, híresség típusú eseményeket is lekérdezzük
if ($adminLevel == 1) {
    $eventsQuery .= " OR type = 'Hírességek'";
}

$eventsResult = mysqli_query($con, $eventsQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['event_id']) && isset($_POST['status'])) {
        $eventId = $_POST['event_id'];
        $status = $_POST['status'];

        // Meghívás hozzáadása vagy frissítése
        $inviteQuery = "INSERT INTO event_invitations (event_id, user_id, status) VALUES ('$eventId', '$userId', '$status') ON DUPLICATE KEY UPDATE status='$status'";
        mysqli_query($con, $inviteQuery);
        header("Location: events.php");
        exit();
    } elseif (isset($_POST['delete_event_id'])) {
        $eventId = $_POST['delete_event_id'];

        // Meghívás törlése
        $deleteQuery = "DELETE FROM event_invitations WHERE event_id='$eventId' AND user_id='$userId'";
        mysqli_query($con, $deleteQuery);
        header("Location: events.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publikus Események</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .event-item {
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .event-item h3 {
            margin-top: 0;
            color: #444;
        }
        .event-item p {
            margin: 5px 0;
            color: #666;
        }
        .event-item .label {
            font-weight: bold;
        }
        .event-item form {
            margin-top: 10px;
        }
        .event-item button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        .event-item button.decline {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
<div class="container">
        <h2>Események</h2>

        <?php
        if (mysqli_num_rows($eventsResult) > 0) {
            while ($row = mysqli_fetch_assoc($eventsResult)) {
                $eventId = $row['id'];
                $name = $row['name'];
                $date = $row['event_date'];
                $place = $row['place'];
                $type = $row['type'];

                // Ellenőrizzük, hogy a felhasználó jelentkezett-e már az eseményre
                $statusQuery = "SELECT status FROM event_invitations WHERE event_id = '$eventId' AND user_id = '$userId'";
                $statusResult = mysqli_query($con, $statusQuery);
                $statusRow = mysqli_fetch_assoc($statusResult);
                $status = $statusRow['status'] ?? '';

                echo "<div class='event-item'>";
                echo "<h3>$name</h3>";
                echo "<p><span class='label'>Időpont:</span> $date</p>";
                echo "<p><span class='label'>Helyszín:</span> $place</p>";
                echo "<p><span class='label'>Típus:</span> $type</p>";

                if ($status) {
                    echo "<form method='POST' action='events.php'>";
                    echo "<input type='hidden' name='delete_event_id' value='$eventId'>";
                    echo "<button type='submit' class='delete'>Jelentkezés törlése</button>";
                    echo "</form>";
                } else {
                    echo "<form method='POST' action='events.php'>";
                    echo "<input type='hidden' name='event_id' value='$eventId'>";
                    echo "<button type='submit' name='status' value='Jön' class='accept'>Jövök</button>";
                    echo "<button type='submit' name='status' value='Talán jön' class='maybe'>Talán jövök</button>";
                    echo "</form>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>Jelenleg nincs publikus esemény.</p>";
        }
        ?>

 <a href="profile.php">Profil</a>
 <a href="dashboard.php">Főoldal</a>        
</body>
</html>