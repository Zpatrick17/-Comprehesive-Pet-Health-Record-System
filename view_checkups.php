<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['id'];
$checkups_query = $conn->query("SELECT c.* FROM checkups c JOIN pets p ON c.pet_id = p.pet_id WHERE p.user_id='$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Checkups</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>Your Checkups</h1>
        <a href="user_dashboard.php">Back to Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Checkups List</h2>
        <table>
            <tr>
                <th>Checkup ID</th>
                <th>Checkup Date</th>
                <th>Next Checkup Due</th>
                <th>Notes</th>
            </tr>
            <?php while ($checkup = $checkups_query->fetch_assoc()): ?>
            <tr>
                <td><?php echo $checkup['checkup_id']; ?></td>
                <td><?php echo $checkup['checkup_date']; ?></td>
                <td><?php echo $checkup['next_checkup_due']; ?></td>
                <td><?php echo $checkup['notes']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
