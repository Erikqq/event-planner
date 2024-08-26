<?php
        require_once 'db_config.php';
		require_once 'auth_session.php';


        $username = $_SESSION['username'];

        // Checking admin level
        $checkAdminQuery = "SELECT adminlevel FROM users WHERE username = '$username'";
        $adminResult = mysqli_query($con, $checkAdminQuery);
        
        if (mysqli_num_rows($adminResult) == 1) {
            $row = mysqli_fetch_assoc($adminResult);
            $adminLevel = $row['adminlevel'];
        
            if ($adminLevel < 1) {
                    header("Location: dashboard.php");
            }
        }
        
        
?>



<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin-styles.css">
    <title>User Info Table</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>
<body>

<div class="navbar">
    <div class="welcome-text">
        <h2>Üdvözöllek, <?php echo $username; ?>!</h2>
    </div>

    <a href="manage_events.php" class="nav-link">Események kezelése</a>
    <a href="admin.php" class="nav-link">Felhasználók</a>
    <a href="celebrities.php" class="nav-link">Hírességek kezelése</a>
    <a class="nav-link">Bejelentkezések</a>
    <a href="dashboard.php" class="nav-link">Kijelentkezés</a>
</div>    

    <div class="content">
        <h2>User Info</h2>
        <table id="userInfoTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IP</th>
                    <th>Device</th>
                    <th>OS</th>
                    <th>Browser</th>
                    <th>Date</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $query = "SELECT id, ip, device, os, browser, date, username FROM user_info";
                $result = mysqli_query($con, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['ip']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['device']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['os']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['browser']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nincs adat a táblában</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userInfoTable').DataTable();
        });
    </script>
</body>
</html>