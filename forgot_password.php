<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Elfelejtett jelszó</title>
    <link rel="stylesheet" href="css/login-style.css"/>
</head>
<body>
<?php
require 'db_config.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email'])) {
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($con, $email);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $token = bin2hex(random_bytes(50)); // Generálj egy véletlenszerű token-t
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token lejárati ideje
        
        $query = "UPDATE users SET reset_token='$token', reset_expiry='$expiry' WHERE email='$email'";
        mysqli_query($con, $query);

        // Küldj e-mailt a felhasználónak
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
            $mail->Subject = 'Jelszó-visszaállító kód';
            $mail->Body    = 'Kérlek, kattints az alábbi linkre a jelszó visszaállításához: ' .
                             'https://void.stud.vts.su.ac.rs/reset_password.php?token=' . $token;

            $mail->send();
            echo "<div class='form'><h3>E-mailt küldtünk a jelszó visszaállításhoz.</h3></div>";
        } catch (Exception $e) {
            echo "<div class='form'><h3>Az e-mail küldése sikertelen volt. Kérlek próbáld újra.</h3></div>";
        }
    } else {
        echo "<div class='form'><h3>Az e-mail cím nem található.</h3></div>";
    }
}
?>

<form class="form" method="post" action="">
    <h1 class="login-title">Elfelejtett jelszó</h1>
    <input type="text" class="login-input" name="email" placeholder="Email cím" required />
    <input type="submit" value="Küldés" class="login-button"/>
    <p class="link"><a href="login.php">Vissza a bejelentkezéshez</a></p>
</form>
</body>
</html>
