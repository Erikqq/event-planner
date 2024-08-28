<?php

require("db_config.php");
include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Felhasználói Profil</title>
    <link rel="stylesheet" href="css/profile-style.css">
</head>

<body>

<?php

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require("db_config.php");


$currentDate = date('Y-m-d H:i:s');

// Események lekérdezése, amelyek időpontja már elmúlt
$eventsQuery = "SELECT * FROM events WHERE event_date < '$currentDate'";
$eventsResult = mysqli_query($con, $eventsQuery);

if (mysqli_num_rows($eventsResult) > 0) {
    while ($row = mysqli_fetch_assoc($eventsResult)) {
        $eventId = $row['id'];
        $name = $row['name'];
        $eventDate = $row['event_date'];
        $place = $row['place'];
        $type = $row['type'];

        // Esemény áthelyezése a 'past_events' táblába
        $insertPastEventQuery = "INSERT INTO past_events (id, name, event_date, place, type) 
                                 VALUES ('$eventId', '$name', '$eventDate', '$place', '$type')";
        mysqli_query($con, $insertPastEventQuery);

        // Meghívások áthelyezése a 'past_event_invitations' táblába
        $invitationsQuery = "SELECT * FROM invitations WHERE event_id = '$eventId'";
        $invitationsResult = mysqli_query($con, $invitationsQuery);

        while ($invitation = mysqli_fetch_assoc($invitationsResult)) {
            $userId = $invitation['user_id'];
            $bringItem = $invitation['bring_item'];
            $status = $invitation['status'];

            $insertPastInvitationQuery = "INSERT INTO past_event_invitations (event_id, user_id, bring_item, status) 
                                          VALUES ('$eventId', '$userId', '$bringItem', '$status')";
            mysqli_query($con, $insertPastInvitationQuery);
        }

        // Törlés az 'events' táblából
        $deleteEventQuery = "DELETE FROM events WHERE id = '$eventId'";
        mysqli_query($con, $deleteEventQuery);

        // Törlés az 'event_invitations' táblából
        $deleteInvitationsQuery = "DELETE FROM invitations WHERE event_id = '$eventId'";
        mysqli_query($con, $deleteInvitationsQuery);
    }
}



$username = $_SESSION['username'];

$checkAdminQuery = "SELECT adminlevel FROM users WHERE username = '$username'";
$adminResult = mysqli_query($con, $checkAdminQuery);

if (mysqli_num_rows($adminResult) == 1) {
    $row = mysqli_fetch_assoc($adminResult);
    $adminLevel = $row['adminlevel'];

    if ($adminLevel > 0) {
        $isAdmin = true;
    } else {
        $isAdmin = false;
    }
} else {
    $isAdmin = false;
}
?>

<?php
    require("db_config.php");

    $username = $_SESSION['username'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $date = $row['create_datetime'];
        $description = $row['description'];
    }
?>

<div class="container">
    <h1>Felhasználói Profil</h1>
    <div class="profile-info">
        <div>
            <label>Felhasználónév:</label>
            <p id="username"><?php echo $username; ?></p>
        </div>
        <div>
            <label>Email:</label>
            <p id="email"><?php echo $email; ?></p>
        </div>
        <div>
            <label>Regisztráció dátuma:</label>
            <p id="email"><?php echo $date; ?></p>
        </div>
        <div>
            <label>Leírás</label>
            <p id="description"><?php echo $description; ?></p>
        </div>

    </div>
    <br>
    <a class="nav-link" href="logout.php">Kijelentkezés</a><br>
    <a class="nav-link" href="dashboard.php">Vissza a főoldalra</a><br>
    <?php if ($isAdmin): ?>
        <a href="admin.php">Admin oldal</a>
    <?php endif; ?>

</div>


<div class="container">
    <h2>Adatok módosítása</h2>
    <form action="update.php" method="POST">
        <div class="form-group">
            <label for="new-email">Új email cím:</label><br>
            <input type="email" id="new-email" name="new-email" required>
        </div>
        <button type="submit" name="change-email">Módosítás</button>
    </form>
    <br>
    <form action="update.php" method="POST">
        <div class="form-group">
            <label for="new-description">Új leírás:</label><br>
            <textarea name="new-description" id="new-description" required></textarea>
        </div>
        <button type="submit" name="change-description">Módosítás</button>
    </form>
</div>

<div class="container">
    <h2>Új esemény létrehozása</h2>
    <form action="add_event.php" method="POST">
        <div class="form-group">
            <label for="name">Esemény neve:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="date">Esemény időpontja:</label>
            <input type="datetime-local" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="place">Esemény helyszíne:</label>
            <input type="text" id="place" name="place" required>
        </div>
        <div class="form-group">
            <label for="type">Esemény típusa:</label>
            <select id="type" name="type" required>
                <option value="Meghívás alapú">Meghívás alapú</option>
                <option value="Publikus">Publikus</option>
                <option value="Hírességek">Hírességek</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comment">Megjegyzés:</label>
            <textarea id="comment" name="comment"></textarea>
        </div>
        <button type="submit">Hozzáadás</button>
    </form>
</div>

<div class="container">
    <h2>Eseményeid listája</h2>

    <?php
    $username = $_SESSION['username'];

    // Események lekérdezése az adott felhasználóhoz
    $eventsQuery = "SELECT * FROM events WHERE user_id IN (SELECT id FROM users WHERE username = '$username')";
    $eventsResult = mysqli_query($con, $eventsQuery);

    // Ha van találat
    if (mysqli_num_rows($eventsResult) > 0) {
        while ($row = mysqli_fetch_assoc($eventsResult)) {
            $eventId = $row['id'];
            $name = $row['name'];
            $date = $row['event_date'];
            $place = $row['place'];
            $type = $row['type'];
            $comment = $row['comment'];

            echo "<div class='event-item'>";
            echo "    <div class='event-info'>";
            echo "<br>";
            echo "        <span class='label'>ID:</span> $eventId<br>";
            echo "        <span class='label'>Esemény neve:</span> $name<br>";
            echo "        <span class='label'>Időpont:</span> $date<br>";
            echo "        <span class='label'>Helyszín:</span> $place<br>";
            echo "        <span class='label'>Típus:</span> $type<br>";
            echo "        <span class='label'>Megjegyzés:</span> $comment<br>";
            echo "    </div>";

            echo "    <form action='delete_event.php' method='POST' onsubmit='return confirm(\"Biztosan törölni szeretnéd ezt az eseményt?\");'>";
            echo "        <input type='hidden' name='delete-event-id' value='$eventId'>";
            echo "        <button type='submit' name='delete-event'>Törlés</button>";
            echo "    </form>";

            // Meghívás gomb
            echo "    <button onclick='showInvitePanel($eventId)'>Meghívás</button>";

            echo "    <button onclick='showArchivePanel($eventId)'>Archívum</button>";

            // Meghívás panel
            echo "    <div id='invite-panel-$eventId' class='invite-panel' style='display:none;'>";
            echo "        <h3>Meghívás küldése</h3>";
            echo "        <form action='invite.php' method='POST'>";
            echo "            <input type='hidden' name='event_id' value='$eventId'>";
            echo "            <div class='form-group'>";
            echo "                <label for='invitee-name-$eventId'>Meghívott neve:</label>";
            echo "                <input type='text' id='invitee-name-$eventId' name='invitee_name' required>";
            echo "            </div>";
            echo "            <div class='form-group'>";
            echo "                <label for='bring-item-$eventId'>Hoznia kell:</label>";
            echo "                <textarea id='bring-item-$eventId' name='bring_item'></textarea>";
            echo "            </div>";
            echo "            <button type='submit'>Meghívás küldése</button>";
            echo "            <button type='button' onclick='hideInvitePanel($eventId)'>Mégse</button>";
            echo "        </form>";
            echo "    </div>";


            // Archívum panel
            echo "    <div id='archive-panel-$eventId' class='archive-panel' style='display:none;'>";
            echo "        <h3>Meghívások archívuma</h3>";
            echo "            <button type='button' onclick='hideArchivePanel($eventId)'>Bezárás</button>";

            // Archívum lekérdezése
            $archiveQuery = "SELECT * FROM invitations WHERE event_id = $eventId";
            $archiveResult = mysqli_query($con, $archiveQuery);

            if (mysqli_num_rows($archiveResult) > 0) {
                while ($invite = mysqli_fetch_assoc($archiveResult)) {
                    $inviteId = $invite['id'];
                    $inviteeName = $invite['invitee_name'];
                    $bringItem = $invite['bring_item'];
                    $status = $invite['status'];

                    echo "<div class='invite-item'>";
                    echo "    <span class='label'>Meghívott neve:</span> $inviteeName<br>";
                    echo "    <span class='label'>Hoznia kell:</span> $bringItem<br>";
                    echo "    <span class='label'>Állapot:</span> $status<br>";

                    // Csak a "Még nem válaszolt" státuszúak törölhetők
                    if ($status === 'Pending') {
                        echo "    <form action='delete_invite.php' method='POST' style='display:inline;'>";
                        echo "        <input type='hidden' name='invite_id' value='$inviteId'>";
                        echo "        <button type='submit'>Törlés</button>";
                        echo "    </form>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<div class='no-invites'>Nincsenek meghívások az eseményhez.</div>";
            }

            echo "    </div>";

            echo "</div>";
        }
    } else {
        // Ha nincs esemény a felhasználónak
        echo "<div class='no-events'>Jelenleg nincs regisztrált eseményed.</div>";
    }
    ?>

    <script>
        function showInvitePanel(eventId) {
            document.getElementById('invite-panel-' + eventId).style.display = 'block';
        }

        function hideInvitePanel(eventId) {
            document.getElementById('invite-panel-' + eventId).style.display = 'none';
        }

        function showArchivePanel(eventId) {
            document.getElementById('archive-panel-' + eventId).style.display = 'block';
        }

        function hideArchivePanel(eventId) {
            document.getElementById('archive-panel-' + eventId).style.display = 'none';
        }
    </script>
</div>

  



<?php

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$checkAdminQuery = "SELECT adminlevel, wants_to_be_celebrity FROM users WHERE username = '$username'";
$adminResult = mysqli_query($con, $checkAdminQuery);

if (mysqli_num_rows($adminResult) == 1) {
    $row = mysqli_fetch_assoc($adminResult);
    $adminLevel = $row['adminlevel'];
    $wantsToBeWalker = $row['wants_to_be_celebrity'];
}
?>

<div class="container">
    <h3>Híresség státusz kérelem</h3>
    <?php if ($adminLevel > 0): ?>
        <?php if ($wantsToBeWalker == 0): ?>
            <p>Te már híresség státusszal rendelkezel.</p>
        <?php else: ?>
            <p>Jelentkeztél hírességnek. Várj amíg feldolgozzák.</p>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($wantsToBeWalker == 0): ?>
            <p>Nem rendelkezel híresség státusszal. Jelentkezz most.</p>
            <form action="set_wants_to_be_celebrity.php" method="POST">
                <button type="submit" name="set-celebrity">Jelentkezés hírességnek</button>
            </form>
        <?php else: ?>
            <p>Jelentkeztél a híresség státuszra. Szeretnéd visszavonni?</p>
            <form action="set_wants_to_be_celebrity.php" method="POST">
                <button type="submit" name="unset-celebrity">Jelentkezés visszavonása</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</div>


<div class="container">
    <h2>Múltbeli események</h2>

    <?php
    // Felhasználó azonosító lekérdezése
    $username = $_SESSION['username'];
    $userQuery = "SELECT id FROM users WHERE username = '$username'";
    $userResult = mysqli_query($con, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $userId = $userData['id'];

    // Múltbeli események lekérdezése, ahol a felhasználó "Jövök" státusszal van
    $pastEventsQuery = "
        SELECT e.id, e.name, e.event_date, e.place, e.type
        FROM past_events e
        JOIN past_event_invitations ei ON e.id = ei.event_id
        WHERE ei.user_id = '$userId' AND ei.status = 'Jön'
        ORDER BY e.event_date DESC
    ";
    $pastEventsResult = mysqli_query($con, $pastEventsQuery);

    if (mysqli_num_rows($pastEventsResult) > 0) {
        while ($row = mysqli_fetch_assoc($pastEventsResult)) {
            $eventId = $row['id'];
            $name = $row['name'];
            $date = $row['event_date'];
            $place = $row['place'];
            $type = $row['type'];

            // Átlagos értékelés lekérdezése
            $averageRatingQuery = "SELECT AVG(rating) as avg_rating FROM event_ratings WHERE event_id = '$eventId'";
            $averageRatingResult = mysqli_query($con, $averageRatingQuery);
            $averageRatingData = mysqli_fetch_assoc($averageRatingResult);
            $averageRating = round($averageRatingData['avg_rating'], 1);

            // Ellenőrizzük, hogy a felhasználó már értékelte-e az eseményt
            $userRatingQuery = "SELECT rating FROM event_ratings WHERE event_id = '$eventId' AND user_id = '$userId'";
            $userRatingResult = mysqli_query($con, $userRatingQuery);
            $userRating = mysqli_fetch_assoc($userRatingResult);

            echo "<div class='event-item'>";
            echo "<h3>$name</h3>";
            echo "<p><span class='label'>Időpont:</span> $date</p>";
            echo "<p><span class='label'>Helyszín:</span> $place</p>";
            echo "<p><span class='label'>Típus:</span> $type</p>";
            echo "<p><span class='label'>Átlag értékelés:</span> " . ($averageRating ? $averageRating : 'Nincs értékelés') . "</p>";

            if (!$userRating) {
                echo "<form method='POST' action='rate_event.php'>";
                echo "<input type='hidden' name='event_id' value='$eventId'>";
                echo "<div class='form-group'>";
                echo "    <label for='rating-$eventId'>Értékelés (1-5):</label>";
                echo "    <select id='rating-$eventId' name='rating' required>";
                echo "        <option value='1'>1</option>";
                echo "        <option value='2'>2</option>";
                echo "        <option value='3'>3</option>";
                echo "        <option value='4'>4</option>";
                echo "        <option value='5'>5</option>";
                echo "    </select>";
                echo "</div>";
                echo "<button type='submit'>Értékelés küldése</button>";
                echo "</form>";
            } else {
                echo "<p>Az értékelésed az eseményre: {$userRating['rating']}</p>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>Nem voltál jelen múltbeli eseményeken.</p>";
    }
    ?>
</div>




</body>
</html>
