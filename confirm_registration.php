<?php
require("db_config.php");
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($con, $_GET['token']);

    // Check if the token exists and is valid
    $query = "SELECT * FROM users WHERE reset_token='$token' AND reset_expiry > NOW()";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $userData = mysqli_fetch_assoc($result);

        // Update user status to verified
        $update_query = "UPDATE users SET email_verified=1, reset_token='', reset_expiry=NULL WHERE reset_token='$token'";
        if (mysqli_query($con, $update_query)) {
            echo "<div class='form'>
                  <h3>Az e-mail címed sikeresen megerősítve.</h3><br/>
                  <p class='link'>Kattints ide, hogy <a href='login.php'>bejelentkezz</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Hiba történt az e-mail cím megerősítésekor. Kérlek próbáld újra.</h3><br/>
                  <p class='link'>Kattints ide, hogy <a href='registration.php'>regisztrálj</a> ismét.</p>
                  </div>";
        }
    } else {
        echo "<div class='form'>
              <h3>Érvénytelen vagy lejárt token. Kérlek próbáld újra a regisztrációt.</h3><br/>
              <p class='link'>Kattints ide, hogy <a href='registration.php'>regisztrálj</a> ismét.</p>
              </div>";
    }
} else {
    echo "<div class='form'>
          <h3>Hiányzó token. Kérlek próbáld újra.</h3><br/>
          <p class='link'>Kattints ide, hogy <a href='registration.php'>regisztrálj</a> ismét.</p>
          </div>";
}
?>
