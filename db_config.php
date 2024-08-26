<?php

/*try {
    $dsn = 'mysql:host=localhost;dbname=proj;charset=utf8';
    $username = 'root';
    $password = '';
    
    $con = new PDO($dsn, $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}*/


$host = "localhost";
$username = "root";
$password = "";
$database = "proj";

$con = mysqli_connect($host, $username, $password, $database);


if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>