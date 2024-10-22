<?php
session_start();
include('db.php');

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: user_dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    // Check if the username or email already exists for users
    $stmt = $conn->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND role = 'user'");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username or email already exists.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, fullname, role) VALUES (?, ?, ?, ?, 'user')");
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $fullname);
        $stmt->execute();
        header('Location: user_login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>User Registration</title>
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="user_login.php">Login here</a></p>
    </div>
</body>
</html>
