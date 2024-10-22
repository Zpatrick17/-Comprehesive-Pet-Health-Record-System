<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'admin'; // Set role to admin
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    // Check if an admin already exists
    $result = $conn->query("SELECT * FROM users WHERE role='admin'");
    if ($result->num_rows > 0) {
        echo "An admin account already exists. Only one admin is allowed.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, email, fullname) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $role, $email, $fullname);

        if ($stmt->execute()) {
            header('Location: admin_login.php'); // Redirect to admin login
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Admin Registration</title>
</head>
<body>
    <div class="form-container">
        <h2>Admin Registration</h2>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" required>

            <button type="submit">Register</button>
            <p>Already have an account? <a href="admin_login.php">Login here</a></p>
        </form>
        <button onclick="window.location.href='login.php'" style="margin-top: 20px;">Back to Login</button>
    </div>
</body>
</html>
