<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $pet_id = $_GET['id'];

    // Fetch vaccination records for the selected pet
    $stmt = $conn->prepare("SELECT * FROM vaccinations WHERE pet_id = ?");
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();
    $results = $stmt->get_result();
} else {
    // If no pet ID is provided, fetch all pets of the logged-in user
    $stmt = $conn->prepare("SELECT pet_id, pet_name FROM pets WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $pets_result = $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vaccinations</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Vaccination Records</h2>

        <?php if (isset($pets_result) && $pets_result->num_rows > 0): ?>
            <h3>Select a Pet:</h3>
            <form method="GET" action="">
                <select name="id" required>
                    <option value="" disabled selected>Select a pet</option>
                    <?php while ($pet = $pets_result->fetch_assoc()): ?>
                        <option value="<?php echo $pet['pet_id']; ?>"><?php echo $pet['pet_name']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit">View Vaccinations</button>
            </form>
        <?php elseif (isset($results) && $results->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Vaccine Name</th>
                    <th>Date Administered</th>
                    <th>Veterinarian</th>
                </tr>
                <?php while ($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['vaccine_name']; ?></td>
                        <td><?php echo $row['date_administered']; ?></td>
                        <td><?php echo $row['veterinarian']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No vaccination records found for this pet.</p>
        <?php endif; ?>

        <!-- Back Button -->
        <a href="user_dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>
