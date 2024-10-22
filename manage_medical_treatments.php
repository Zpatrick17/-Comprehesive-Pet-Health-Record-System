<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Medical Treatments - Comprehensive Pet Health Record System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Manage Medical Treatments</h1>
    <p>Functionality to manage medical treatments will be implemented here.</p>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
