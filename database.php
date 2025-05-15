<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "php_login_database"; // tu nombre real de base de datos

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
