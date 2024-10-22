<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>User Dashboard</h1>
        <a href="view_pets.php">View Pets</a>
        <a href="add_pet.php">Add Pet</a>
        <a href="view_vaccinations.php">View Vaccinations</a>
        <a href="view_medical_treatments.php">View Medical Treatments</a>
        <a href="view_checkups.php">View Checkups</a>
        <a href="schedule_appointment.php">Schedule Appointment</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Welcome, User!</h2>
        <p>Select an option from the navigation above to manage your pet records.</p>
    </div>
</body>
</html>
