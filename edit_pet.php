<?php
session_start();
include('db.php');

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

// Check if pet_id is provided
if (!isset($_GET['pet_id'])) {
    echo "No pet ID provided. Please go back and select a pet.";
    exit();
}

// Fetch pet details
$pet_id = $_GET['pet_id'];
$stmt = $conn->prepare("SELECT pet_name, species, breed, date_of_birth, gender FROM pets WHERE pet_id = ?");
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No pet found with this ID.";
    exit();
}

$pet = $result->fetch_assoc();

// Handle the update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet_name = $_POST['pet_name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];

    $update_stmt = $conn->prepare("UPDATE pets SET pet_name = ?, species = ?, breed = ?, date_of_birth = ?, gender = ? WHERE pet_id = ?");
    $update_stmt->bind_param("sssssi", $pet_name, $species, $breed, $date_of_birth, $gender, $pet_id);

    if ($update_stmt->execute()) {
        echo "Pet updated successfully.";
        header("Location: manage_pets.php");
        exit();
    } else {
        echo "Error updating pet: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>Edit Pet</h1>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_vaccinations.php">Manage Vaccinations</a>
            <a href="manage_medical_treatments.php">Manage Medical Treatments</a>
            <a href="manage_checkups.php">Manage Checkups</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>

    <div class="container">
        <h2>Edit Pet Details</h2>
        <form method="POST">
            <label for="pet_name">Pet Name:</label>
            <input type="text" id="pet_name" name="pet_name" value="<?php echo htmlspecialchars($pet['pet_name']); ?>" required>

            <label for="species">Species:</label>
            <input type="text" id="species" name="species" value="<?php echo htmlspecialchars($pet['species']); ?>" required>

            <label for="breed">Breed:</label>
            <input type="text" id="breed" name="breed" value="<?php echo htmlspecialchars($pet['breed']); ?>" required>

            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($pet['date_of_birth']); ?>" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php echo ($pet['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($pet['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>

            <button type="submit">Update Pet</button>
        </form>
        <a href="manage_pets.php">Back to Pet Management</a>
    </div>
</body>
</html>
