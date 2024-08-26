<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="css/login-style.css"/>
</head>
<body>
<?php
require("db_config.php");

require_once "device_report.php"; 
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$device_repo = new DeviceRepository($user_agent);

session_start();



// Guest login
if (isset($_POST['submit_guest'])) {
    $_SESSION['username'] = "Vendég";
    header("Location: dashboard.php");
    exit();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function collectdata($con, $device_repo, $username) {
    // Retrieve data from the DeviceRepository
    $ip = $device_repo->get_ip();
    $device = $device_repo->get_device();
    $os = $device_repo->get_os();
    $browser = $device_repo->get_browser();
    $date = date('Y-m-d H:i:s');
    
    // Prepare the SQL query
    $query = "INSERT INTO user_info (ip, device, os, browser, date, username) 
              VALUES (?, ?, ?, ?, ?, ?)";
    
    // Initialize the prepared statement
    if ($stmt = mysqli_prepare($con, $query)) {
        // Bind parameters to the query
        mysqli_stmt_bind_param($stmt, "ssssss", $ip, $device, $os, $browser, $date, $username);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Data successfully inserted.";
        } else {
            echo "Error inserting data: " . mysqli_error($con);
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($con);
    }
}

if (isset($_POST['username'])) {
    $username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($con, $username);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);

    $query = "SELECT * FROM `users` WHERE username='$username'
              AND password='" . md5($password) . "'";
    $result = mysqli_query($con, $query) or die(mysql_error());
    $rows = mysqli_num_rows($result);

    if ($rows == 1) {
        $userData = mysqli_fetch_assoc($result);

        if ($userData['banned'] == 1) {
            echo "<div class='form'>
                  <h3>A fiókod tiltva van.</h3><br/>
                  <p class='link'>Kattints ide az ismételt <a href='login.php'>bejelentkezéshez</a>.</p>
                  </div>";
        } else {
            $_SESSION['username'] = $username;
            collectdata($con, $device_repo, $username);
            header("Location: dashboard.php");
            exit();
        }
    } else {
        echo "<div class='form'>
              <h3>Ismeretlen jelszó és név páros.</h3><br/>
              <p class='link'>Kattints ide az ismételt <a href='login.php'>bejelentkezéshez</a>.</p>
              </div>";
    }
} else {
    ?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Bejelentkezés</h1>
        <input type="text" class="login-input" name="username" placeholder="Felhasználónév" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Jelszó"/>
        <input type="submit" value="Bejelentkezés" name="submit" class="login-button"/><br><br>
        <input type="submit" value="Vendégként belépés" name="submit_guest" class="login-button"/>
        <p class="link">Még nincs felhasználód? <a href="registration.php">Regisztrálj most!</a></p>

  </form>
<?php
    }
?>
</body>
</html>
