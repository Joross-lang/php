<?php
$servername = "localhost";
$username = "root"; // Change if needed
$password = "";
$database = "student_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
