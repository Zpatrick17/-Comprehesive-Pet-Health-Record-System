<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['pet_id'])) {
    $pet_id = $_GET['pet_id'];
    $conn->query("DELETE FROM pets WHERE pet_id = $pet_id");
    header('Location: manage_pets.php');
    exit();
}
?>
