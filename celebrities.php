<?php

require("db_config.php");
require("auth_session.php");

$username = $_SESSION['username'];

$checkAdminQuery = "SELECT adminlevel FROM users WHERE username = '$username'";
$adminResult = mysqli_query($con, $checkAdminQuery);

if (mysqli_num_rows($adminResult) == 1) {
    $row = mysqli_fetch_assoc($adminResult);
    $adminLevel = $row['adminlevel'];

    if ($adminLevel < 1) {
            header("Location: dashboard.php");
    }
}

$adminQuery = "SELECT id, username, email, create_datetime FROM users WHERE adminlevel = 1";
$adminResult = mysqli_query($con, $adminQuery);

$workerQuery = "SELECT id, username, email, description FROM users WHERE wants_to_be_celebrity = 1";
$workerResult = mysqli_query($con, $workerQuery);



if (isset($_GET['targetUserId']) && isset($_GET['adminLevel'])) {
    $targetUserId = mysqli_real_escape_string($con, $_GET['targetUserId']);
    $adminLevel = mysqli_real_escape_string($con, $_GET['adminLevel']);

    $getUserQuery = "SELECT username, adminlevel FROM users WHERE id = '$targetUserId'";
    $userResult = mysqli_query($con, $getUserQuery);

    if (mysqli_num_rows($userResult) == 1) {
        $updateAdminQuery = "UPDATE users SET adminlevel = '$adminLevel', wants_to_be_celebrity = 0 WHERE id = '$targetUserId'";
        if (mysqli_query($con, $updateAdminQuery)) {
            echo "<script>
                alert('Adminlevel sikeresen módosítva.');
                window.location.href = 'celebrities.php';
              </script>";
        } else {
            echo "<script>
                alert('Adminlevel módosítása sikertelen.');
                window.location.href = 'celebrities.php';
              </script>";
        }
    } else {
        echo "<script>
                alert('Nem található ilyen felhasználó.');
                window.location.href = 'celebrities.php';
              </script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Oldal</title>
    <link rel="stylesheet" href="css/admin-styles.css">
</head>
<body>
<div class="navbar">
    <div class="welcome-text">
        <h2>Üdvözöllek, <?php echo $username; ?>!</h2>
    </div>

    <a href="manage_events.php" class="nav-link">Események kezelése</a>
    <a href="admin.php" class="nav-link">Felhasználók</a>
    <a class="nav-link">Hírességek kezelése</a>
    <a href="logins.php" class="nav-link">Bejelentkezések</a>
    <a href="dashboard.php" class="nav-link">Kijelentkezés</a>
</div>

<div class="content">

    <div class="content-2">
        <h1>Hírességek</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Felhasználónév</th>
                <th>Email</th>
                <th>Létrehozás dátuma</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($adminResult)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['create_datetime'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

    </div>
        <br>
        <div class="content-2">
            <h2>Híresség szint Módosítása</h2>
            <form action="" method="GET">
                <label for="targetUserId">Cél felhasználó ID:</label>
                <input type="text" id="targetUserId" name="targetUserId" required>
                <label for="adminLevel">Szint:</label>
                <select id="adminLevel" name="adminLevel" required>
                    <option value="0">0</option>
                    <option value="1">1</option>
                </select>
                <button type="submit">Módosítás</button>
            </form>
        </div>
    <br>
    <div class="content-2">
        <h2>Híresség jelentkezések</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Felhasználónév</th>
                <th>Email</th>
                <th>Leírás</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($workerResult)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

</div>

</body>
</html>
