<?php
$host = "localhost";
$username = "galih";
$password = "galihganteng";
$dbname = "galih_crud";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

