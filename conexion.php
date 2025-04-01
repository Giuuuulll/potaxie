<?php
$servername = "localhost";
$username = "u178928053_giuli";
$password = "5yS[!~b[Acq&";
$dbname = "u178928053_potaxies"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
