<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

// Similar logic for viewing, adding, and deleting checkups can be implemented here.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Checkups</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>Manage Checkups</h1>
        <a href="admin_dashboard.php">Back to Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Checkups List</h2>
        <!-- Logic to display checkups goes here -->
    </div>
</body>
</html>
