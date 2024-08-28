<?php
include("auth_session_guest.php");
require("db_config.php");
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eseményszervezés</title>
    <link rel="stylesheet" href="css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Eseményszervezés</a>
            <ul class="nav-links">
                <?php
                if ($_SESSION['username'] == "Vendég") {
                    echo '<li class="nav-item">
                        <a class="nav-link" href="registration.php"><i class="fa fa-user-plus"></i> Regisztráció</a>
                    </li>';
                } else {
                    echo '<li class="nav-item">
                        <a class="nav-link" href="profile.php"><i class="fa fa-user"></i> Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out-alt"></i> Kijelentkezés</a>
                    </li>';               
                }
                ?>
            </ul>
        </div>
    </nav>
</header>

<section id="hero" class="hero-section">
    <div class="hero-content">
        <h1>Események szervezése egyszerűen</h1>
        <p>Fedezd fel szolgáltatásainkat, és hozz létre vagy böngéssz eseményeket könnyedén.</p>
        <a href="events.php" class="btn btn-primary"><i class="fa fa-calendar-check"></i> Fedezd fel az eseményeket</a>
    </div>
</section>

<section id="about" class="section">
    <div class="container">
        <div class="section-header">
            <h2>Rólunk</h2>
        </div>
        <div class="section-content">
            <p>Az oldal lehetőséget biztosít események szervezésére és publikus események böngészésére. Könnyen kezelheted az eseményeidet és kapcsolatba léphetsz másokkal.</p>
        </div>
    </div>
</section>

<section id="services" class="section bg-light">
    <div class="container">
        <div class="section-header">
            <h2>Szolgáltatások</h2>
        </div>
        <div class="section-content">
            <ul>
                <li><i class="fa fa-calendar-check"></i> Esemény létrehozás</li>
                <li><i class="fa fa-search"></i> Események böngészése</li>
            </ul>
        </div>
    </div>
</section>

<section id="contact" class="section">
    <div class="container">
        <div class="section-header">
            <h2>Kapcsolat</h2>
        </div>
        <div class="section-content">
            <p>Írj nekünk: <a href="mailto:esemenyszervezo@gmail.com">esemenyszervezo@gmail.com</a></p>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <p>© 2024 VTS</p>
    </div>
</footer>

</body>
</html>
