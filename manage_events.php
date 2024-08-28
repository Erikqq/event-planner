<?php

require("db_config.php");
require("auth_session.php");

$username = $_SESSION['username'];


$checkAdminQuery = "SELECT adminlevel FROM users WHERE username = '$username'";
$adminResult = mysqli_query($con, $checkAdminQuery);

if (mysqli_num_rows($adminResult) == 1) {
    $row = mysqli_fetch_assoc($adminResult);
    $adminLevel = $row['adminlevel'];


    if ($adminLevel > 0) {
        if($adminLevel == 2){
            $isAdmin2 = true;
        } else{
            $isAdmin2 = false;
        }

    } else {
        header("Location: dashboard.php");
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}


$query = "SELECT * FROM events";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <title>Admin Oldal</title>
    <link rel="stylesheet" href="css/admin-styles.css">
</head>
<body>
<div class="navbar">
    <div class="welcome-text">
        <h2>Üdvözöllek, <?php echo $username; ?>!</h2>
    </div>


    <a class="nav-link">Események kezelése</a>
    <a href="admin.php" class="nav-link">Felhasználók</a>
    <a href="celebrities.php" class="nav-link">Hírességek kezelése</a>
    <a href="logins.php" class="nav-link">Bejelentkezések</a>
    <a href="dashboard.php" class="nav-link">Kijelentkezés</a>
</div>



<div class="content">

<h1>Események</h1>
    <table id="eventsTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Location</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
            <tr>
                <td><?php echo htmlspecialchars($event['id']); ?></td>
                <td><?php echo htmlspecialchars($event['name']); ?></td>
                <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                <td><?php echo htmlspecialchars($event['place']); ?></td>
                <td><?php echo htmlspecialchars($event['comment']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!-- DataTables initialization -->
    <script>
        $(document).ready(function() {
            $('#eventsTable').DataTable();
        });
    </script>
    
    <div class="container">

    <?php
    if (isset($_GET['id'])) {
        $eventId = $_GET['id'];
        $eventQuery = "SELECT * FROM events WHERE id = '$eventId'";
        $eventResult = mysqli_query($con, $eventQuery);
        $event = mysqli_fetch_assoc($eventResult);
    }
    ?>

<div class="container">
    <div class="container">
    <h2>Esemény módosítása</h2>

    <form method="GET" action="">
        <div class="form-group">
            <label for="event_id">Esemény kiválasztása:</label>
            <select id="event_id" name="event_id" onchange="this.form.submit()" required>
                <option value="">Válassz eseményt</option>
                <?php
                // Lekérdezzük az összes eseményt
                $eventsQuery = "SELECT id, name FROM events";
                $eventsResult = mysqli_query($con, $eventsQuery);

                while ($event = mysqli_fetch_assoc($eventsResult)) {
                    $selected = (isset($_GET['event_id']) && $_GET['event_id'] == $event['id']) ? 'selected' : '';
                    echo "<option value='{$event['id']}' $selected>{$event['name']}</option>";
                }
                ?>
            </select>
        </div>
    </form>

    <?php
    if (isset($_GET['event_id']) && !empty($_GET['event_id'])) {
        $eventId = $_GET['event_id'];

        // Lekérdezzük az esemény részleteit az esemény ID alapján
        $eventQuery = "SELECT * FROM events WHERE id = '$eventId'";
        $eventResult = mysqli_query($con, $eventQuery);
        $event = mysqli_fetch_assoc($eventResult);

        if ($event) {
            // Az esemény részleteinek kitöltése
            $eventDateTime = date('Y-m-d\TH:i', strtotime($event['event_date']));
            ?>
            <form method="POST" action="edit_event.php">
                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                <div class="form-group">
                    <label for="name">Név:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="event_date">Időpont:</label>
                    <input type="datetime-local" id="event_date" name="event_date" value="<?php echo $eventDateTime; ?>" required>
                </div>
                <div class="form-group">
                    <label for="place">Helyszín:</label>
                    <input type="text" id="place" name="place" value="<?php echo htmlspecialchars($event['place']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="type">Típus:</label>
                    <select id="type" name="type" required>
                        <option value="Publikus" <?php echo ($event['type'] == 'Publikus') ? 'selected' : ''; ?>>Publikus</option>
                        <option value="Privát" <?php echo ($event['type'] == 'Privát') ? 'selected' : ''; ?>>Privát</option>
                        <option value="Meghívás alapú" <?php echo ($event['type'] == 'Meghívás alapú') ? 'selected' : ''; ?>>Meghívás alapú</option>
                    </select>
                </div>
                <button type="submit" name="edit_event">Módosítás</button>
            </form>
            <?php
        } else {
            echo "<p>Esemény nem található.</p>";
        }
    }
    ?>
</div>
<h2>Esemény törlése</h2>
<form method="POST" action="delete_event_admin.php" style="margin-top: 20px;">
    <div class="form-group">
        <label for="event_id">Esemény ID:</label>
        <input type="text" id="event_id" name="event_id" required>
    </div>
    <button type="submit" name="delete_event">Törlés</button>
</form>

</div>    

<!-- Form for blocking an event -->
<h2>Esemény betiltása</h2>
<form method="POST" action="block_event.php">
    <div class="form-group">
        <label for="block_event_id">Esemény ID:</label>
        <input type="text" id="block_event_id" name="event_id" required>
    </div>
    <button type="submit" name="block_event">Betiltás</button>
</form>

<!-- Form for unblocking an event -->
<h2>Esemény engedélyezése</h2>
<form method="POST" action="unblock_event.php">
    <div class="form-group">
        <label for="unblock_event_id">Esemény ID:</label>
        <input type="text" id="unblock_event_id" name="event_id" required>
    </div>
    <button type="submit" name="unblock_event">Engedélyezés</button>
</form>

<!-- List of blocked events -->
<h2>Betiltott események</h2>
<?php
$query = "SELECT * FROM blocked_events";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$blocked_events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $blocked_events[] = $row;
}

if (empty($blocked_events)) {
    echo "<p>Nincsenek betiltott események.</p>";
} else {
    echo "<ul>";
    foreach ($blocked_events as $event) {
        echo "<li>ID: {$event['id']}, Név: {$event['name']}, Időpont: {$event['event_date']}, Helyszín: {$event['place']}</li>";
    }
    echo "</ul>";
}
?>

</body>
</html>
