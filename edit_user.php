<?php
session_start();
include('db.php');

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "No user ID provided.";
    exit();
}

$user_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, fullname = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $fullname, $user_id);
    if ($stmt->execute()) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error updating user.";
    }
} else {
    // Fetch user details to pre-fill the form
    $stmt = $conn->prepare("SELECT username, email, fullname FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
}
?>

<form method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" value="<?php echo $user['username']; ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

    <label for="fullname">Full Name:</label>
    <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" required>

    <button type="submit">Update User</button>
</form>
