<?php
$host = 'localhost';
$user = 'root'; // Update with your DB username
$password = ''; // Update with your DB password
$database = 'pet_health_records';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
