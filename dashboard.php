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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>


<header>
    <nav class="navbar">
        <a class="navbar-brand" href="#">Eseményszervezés</a>
        <ul class="nav-links">


            <?php
            if ($_SESSION['username'] == "Vendég") {
                echo '<li class="nav-item">
                    <a class="nav-link" href="registration.php">Regisztráció</a>
                </li>';
            } else {
                echo '<li class="nav-item">
                    <a class="nav-link" href="profile.php">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Kijelentkezés</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="events.php">Publikus események</a>
                </li>               
                ';
            }
            ?>


        </ul>
    </nav>
</header>

<section id="about" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="section-content">
                    <h2 class="section-heading">Rólunk</h2>
                    <p>Az oldal lehetőséget biztosít események szervezésére, és publikus események böngészésére.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services" class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="section-content">
                    <h2 class="section-heading">Szolgáltatások</h2>
                    <ul>
                        <li>Esemény létrehozás</li>
                        <li>Események böngészése</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="section-content">
                    <h2 class="section-heading">Kapcsolat</h2>
                    <p>Írj nekünk: esemenyszervezo@gmail.com</p>
                </div>
            </div>
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

