<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["username"] == "Vendég") {
    header("Location: login.php");
    exit();
}
?>