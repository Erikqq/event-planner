<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Jelszó visszaállítása</title>
    <link rel="stylesheet" href="css/login-style.css"/>
</head>
<body>
<?php
require 'db_config.php';

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($con, $_GET['token']);

    $query = "SELECT * FROM users WHERE reset_token='$token' AND reset_expiry > NOW()";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        if (isset($_POST['password'])) {
            $password = stripslashes($_POST['password']);
            $password = mysqli_real_escape_string($con, $password);
            $hashed_password = md5($password);

            $query = "UPDATE users SET password='$hashed_password', reset_token=NULL, reset_expiry=NULL WHERE reset_token='$token'";
            mysqli_query($con, $query);
            echo "<div class='form'><h3>Jelszó sikeresen visszaállítva.</h3><br/><p class='link'><a href='login.php'>Bejelentkezés</a></p></div>";
        } else {
            ?>
            <form class="form" method="post" action="">
                <h1 class="login-title">Jelszó visszaállítása</h1>
                <input type="password" class="login-input" name="password" placeholder="Új jelszó" required />
                <input type="submit" value="Visszaállítás" class="login-button"/>
            </form>
            <?php
        }
    } else {
        echo "<div class='form'><h3>Érvénytelen vagy lejárt token.</h3></div>";
    }
} else {
    echo "<div class='form'><h3>Hiányzó token.</h3></div>";
}
?>
</body>
</html>
