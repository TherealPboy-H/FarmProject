<?php
$host = "localhost";
$user = "root";
$pass = ""; // XAMPP default is empty
$dbname = "soil_track_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>