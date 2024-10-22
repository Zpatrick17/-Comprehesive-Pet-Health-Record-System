<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php'); // Redirect to user login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user ID from the session

// Fetch pets for the logged-in user
$stmt = $conn->prepare("SELECT * FROM pets WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Pets</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>Your Pets</h1>
        <a href="add_pet.php">Add Pet</a>
        <a href="user_dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Your Pet List</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Pet Name</th>
                        <th>Species</th>
                        <th>Breed</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pet = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pet['pet_name']); ?></td>
                            <td><?php echo htmlspecialchars($pet['species']); ?></td>
                            <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                            <td><?php echo htmlspecialchars($pet['date_of_birth']); ?></td>
                            <td><?php echo htmlspecialchars($pet['gender']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pets found. Please add some pets!</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
