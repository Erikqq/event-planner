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

    if (isset($_REQUEST['username'])) {

        $username = stripslashes($_REQUEST['username']);

        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $create_datetime = date("Y-m-d H:i:s");
        $query    = "INSERT into `users` (username, password, email, create_datetime)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>Sikeres regisztráció.</h3><br/>
                  <p class='link'>Kattints ide hogy <a href='login.php'>bejelentkezz</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>A kötelező mezők hiányoznak.</h3><br/>
                  <p class='link'>Kattints ide hogy <a href='registration.php'>regisztrálj</a> ismét.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Regisztráció</h1>
        <input type="text" class="login-input" name="username" placeholder="Felhasználónév" required />
        <input type="text" class="login-input" name="email" placeholder="Email cím">
        <input type="password" class="login-input" name="password" placeholder="Jelszó">
        <input type="submit" name="submit" value="Regisztráció" class="login-button">
        <p class="link">Már regisztráltál? <a href="login.php">Kattints a bejelentkezéshez</a></p>
    </form>
<?php
    }
?>
</body>
</html>
