<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['id'];
$treatments_query = $conn->query("SELECT t.* FROM medical_treatments t JOIN pets p ON t.pet_id = p.pet_id WHERE p.user_id='$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Medical Treatments</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>Your Medical Treatments</h1>
        <a href="user_dashboard.php">Back to Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Medical Treatments List</h2>
        <table>
            <tr>
                <th>Treatment ID</th>
                <th>Treatment Date</th>
                <th>Treatment Type</th>
                <th>Description</th>
            </tr>
            <?php while ($treatment = $treatments_query->fetch_assoc()): ?>
            <tr>
                <td><?php echo $treatment['treatment_id']; ?></td>
                <td><?php echo $treatment['treatment_date']; ?></td>
                <td><?php echo $treatment['treatment_type']; ?></td>
                <td><?php echo $treatment['description']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
