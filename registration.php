<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="css/login-style.css"/>
</head>
<body>
<?php
require("db_config.php");
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_REQUEST['username'])) {
    $username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($con, $username);
    $email    = stripslashes($_REQUEST['email']);
    $email    = mysqli_real_escape_string($con, $email);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);
    $create_datetime = date("Y-m-d H:i:s");
    
    // Check if username or email already exists
    $query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='form'>
              <h3>A felhasználónév vagy az e-mail cím már létezik.</h3><br/>
              <p class='link'>Kattints ide hogy <a href='registration.php'>regisztrálj</a> ismét.</p>
              </div>";
    } else {
        $query = "INSERT INTO users (username, password, email, create_datetime, reset_token, reset_expiry)
                  VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime', '', '')";
        $result = mysqli_query($con, $query);
        
        if ($result) {
            // Generate and send confirmation email
            $token = bin2hex(random_bytes(50)); // Generate a random token
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiry time

            $query = "UPDATE users SET reset_token='$token', reset_expiry='$expiry' WHERE email='$email'";
            mysqli_query($con, $query);

            // Send confirmation email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'mail.void.stud.vts.su.ac.rs';
                $mail->SMTPAuth = true;
                $mail->Username = 'void';
                $mail->Password = 'n3cQPMl19XdpPt7';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('void@void.stud.vts.su.ac.rs', 'Esemeny szervezo');
                $mail->addAddress($email);
                $mail->Subject = 'Regisztracio megerositese';
                $mail->Body    = 'Kérlek, kattints az alábbi linkre a regisztráció megerősítéséhez: ' .
                                 'https://void.stud.vts.su.ac.rs/confirm_registration.php?token=' . $token;

                $mail->send();
                echo "<div class='form'>
                      <h3>Sikeres regisztráció. Kérlek, ellenőrizd az e-mail fiókodat a regisztráció megerősítéséhez.</h3><br/>
                      <p class='link'>Kattints ide hogy <a href='login.php'>bejelentkezz</a></p>
                      </div>";
            } catch (Exception $e) {
                echo "<div class='form'>
                      <h3>Az e-mail küldése sikertelen volt. Kérlek próbáld újra.</h3><br/>
                      <p class='link'>Kattints ide hogy <a href='registration.php'>regisztrálj</a> ismét.</p>
                      </div>";
            }
        } else {
            echo "<div class='form'>
                  <h3>A regisztráció nem sikerült. Kérlek próbáld újra.</h3><br/>
                  <p class='link'>Kattints ide hogy <a href='registration.php'>regisztrálj</a> ismét.</p>
                  </div>";
        }
    }
} else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Regisztráció</h1>
        <input type="text" class="login-input" name="username" placeholder="Felhasználónév" required />
        <input type="text" class="login-input" name="email" placeholder="Email cím" required />
        <input type="password" class="login-input" name="password" placeholder="Jelszó" required />
        <input type="submit" name="submit" value="Regisztráció" class="login-button">
        <p class="link">Már regisztráltál? <a href="login.php">Kattints a bejelentkezéshez</a></p>
    </form>
<?php
}
?>
</body>
</html>
