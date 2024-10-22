<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles1.css">
    <title>Login</title>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <p>Please choose your login type:</p>
        <form action="admin_login.php" method="get">
            <button type="submit" class="login-btn">Admin Login</button>
        </form>
        <form action="user_login.php" method="get">
            <button type="submit" class="login-btn">User Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
