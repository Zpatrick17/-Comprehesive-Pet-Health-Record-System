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

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header('Location: manage_users.php');
    exit();
} else {
    echo "Error deleting user.";
}
?>
