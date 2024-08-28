<?php
include("auth_session.php");
require("db_config.php");

// Get the current user's admin level
$username = $_SESSION['username'];
$adminQuery = "SELECT adminLevel FROM users WHERE username='$username'";
$adminResult = mysqli_query($con, $adminQuery);
$adminLevel = mysqli_fetch_assoc($adminResult)['adminLevel'];

// Construct the query based on admin level
if ($adminLevel == 1) {
    // If adminLevel is 1, show both public and celebrity events
    $query = "SELECT * FROM events WHERE type='Publikus' OR type='Híresség' ORDER BY event_date DESC";
} else {
    // If adminLevel is not 1, show only public events
    $query = "SELECT * FROM events WHERE type='Publikus' ORDER BY event_date DESC";
}

$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publikus Események</title>
    <link rel="stylesheet" href="css/styles-events.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Eseményszervezés</a>
            <ul class="nav-links">
                <?php
                if ($_SESSION['username'] == "Vendég") {
                    echo '<li class="nav-item">
                        <a class="nav-link" href="registration.php"><i class="fa fa-user-plus"></i> Regisztráció</a>
                    </li>';
                } else {
                    echo '<li class="nav-item">
                        <a class="nav-link" href="profile.php"><i class="fa fa-user"></i> Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="fa fa-sign-out-alt"></i> Főoldal</a>
                    </li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>

<section id="events" class="section">
    <div class="container">
        <div class="section-header">
            <h2>Események</h2>
        </div>
        <div class="section-content">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <ul class="event-list">
                    <?php while ($event = mysqli_fetch_assoc($result)): ?>
                        <li class="event-item">
                            <div class="event-date">
                                <i class="fa fa-calendar-alt"></i>
                                <?php echo date('Y.m.d', strtotime($event['event_date'])); ?>
                            </div>
                            <div class="event-details">
                                <h3><?php echo htmlspecialchars($event['name']); ?></h3>
                                <p><strong>Helyszín:</strong> <?php echo htmlspecialchars($event['place']); ?></p>
                                <p><strong>Típus:</strong> <?php echo htmlspecialchars($event['type']); ?></p>
                                <p><strong>Leírás:</strong> <?php echo htmlspecialchars($event['comment']); ?></p>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Nincsenek elérhető publikus események.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="invitations" class="section">
    <div class="container">
        <div class="section-header">
            <h2>Meghívások kezelése</h2>
        </div>
        <div class="section-content">
            <?php
            // Meghívások lekérdezése a felhasználóhoz
            $invitationsQuery = "
                SELECT ei.id AS invite_id, e.name AS event_name, e.event_date, e.place, e.type, e.comment, ei.bring_item, ei.status
                FROM invitations ei
                JOIN events e ON ei.event_id = e.id
                WHERE ei.invitee_name = '$username'
            ";
            $invitationsResult = mysqli_query($con, $invitationsQuery);

            // Visszajelzett meghívások listája
            echo "<h3>Visszajelzett meghívások</h3>";
            echo "<div class='responses-list'>";
            $responsesQuery = "
                SELECT ei.id AS invite_id, e.name AS event_name, e.event_date, e.place, e.type, e.comment, ei.bring_item, ei.status
                FROM invitations ei
                JOIN events e ON ei.event_id = e.id
                WHERE ei.invitee_name = '$username' AND ei.status != 'Pending'
                ORDER BY ei.event_id
            ";
            $responsesResult = mysqli_query($con, $responsesQuery);

            if (mysqli_num_rows($responsesResult) > 0) {
                while ($row = mysqli_fetch_assoc($responsesResult)) {
                    $inviteId = $row['invite_id'];
                    $eventName = $row['event_name'];
                    $eventDate = $row['event_date'];
                    $place = $row['place'];
                    $type = $row['type'];
                    $comment = $row['comment'];
                    $bringItem = $row['bring_item'];
                    $status = $row['status'];

                    echo "<div class='invitation-item'>";
                    echo "    <h4>$eventName</h4>";
                    echo "    <p><strong>Időpont:</strong> $eventDate</p>";
                    echo "    <p><strong>Helyszín:</strong> $place</p>";
                    echo "    <p><strong>Megjegyzés:</strong> $comment</p>";
                    echo "    <p><strong>Hoznia kell:</strong> $bringItem</p>";
                    echo "    <p><strong>Állapot:</strong> $status</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nincsenek visszajelzett meghívások.</p>";
            }
            echo "</div>";

            // Aktuális meghívások, ahol a státusz "Még nem válaszolt"
            echo "<h3>Aktuális meghívások</h3>";
            echo "<div class='invitations-list'>";
            $currentInvitationsQuery = "
                SELECT ei.id AS invite_id, e.name AS event_name, e.event_date, e.place, e.type, e.comment, ei.bring_item, ei.status
                FROM invitations ei
                JOIN events e ON ei.event_id = e.id
                WHERE ei.invitee_name = '$username' AND ei.status = 'Pending'
            ";
            $currentInvitationsResult = mysqli_query($con, $currentInvitationsQuery);

            if (mysqli_num_rows($currentInvitationsResult) > 0) {
                while ($row = mysqli_fetch_assoc($currentInvitationsResult)) {
                    $inviteId = $row['invite_id'];
                    $eventName = $row['event_name'];
                    $eventDate = $row['event_date'];
                    $place = $row['place'];
                    $type = $row['type'];
                    $comment = $row['comment'];
                    $bringItem = $row['bring_item'];
                    $status = $row['status'];

                    echo "<div class='invitation-item'>";
                    echo "    <h4>$eventName</h4>";
                    echo "    <p><strong>Időpont:</strong> $eventDate</p>";
                    echo "    <p><strong>Helyszín:</strong> $place</p>";
                    echo "    <p><strong>Megjegyzés:</strong> $comment</p>";
                    echo "    <p><strong>Hoznia kell:</strong> $bringItem</p>";

                    // Válasz státusz frissítése
                    echo "    <form action='update_status.php' method='POST' class='response-form'>";
                    echo "        <input type='hidden' name='invite_id' value='$inviteId'>";
                    echo "        <select name='status' required>";
                    echo "            <option value='Jön' " . ($status === 'Jön' ? 'selected' : '') . ">Jön</option>";
                    echo "            <option value='Nem jön' " . ($status === 'Nem jön' ? 'selected' : '') . ">Nem jön</option>";
                    echo "            <option value='Talán jön' " . ($status === 'Talán jön' ? 'selected' : '') . ">Talán jön</option>";
                    echo "        </select>";
                    echo "        <button type='submit'>Válasz küldése</button>";
                    echo "    </form>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nincsenek aktuális meghívások.</p>";
            }
            echo "</div>";
            ?>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; 2024 Eseményszervezés. Minden jog fenntartva.</p>
    </div>
</footer>

</body>
</html>
