<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Handle adding pet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet_name = $_POST['pet_name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];

    // Add new pet
    $stmt = $conn->prepare("INSERT INTO pets (user_id, pet_name, species, breed, date_of_birth, gender) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $pet_name, $species, $breed, $date_of_birth, $gender);

    if ($stmt->execute()) {
        // Redirect back to add_pet.php to add another pet
        header('Location: add_pet.php');
        exit();
    } else {
        $error = 'Error adding pet. Please try again.';
    }
}

// Fetch pets for the logged-in user
$pets_result = $conn->prepare("SELECT * FROM pets WHERE user_id = ?");
$pets_result->bind_param("i", $user_id);
$pets_result->execute();
$pets = $pets_result->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Add Pet</title>
</head>
<body>
    <div class="container">
        <h2>Add a New Pet</h2>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="text" name="pet_name" placeholder="Pet Name" required>
            <input type="text" name="species" placeholder="Species" required>
            <input type="text" name="breed" placeholder="Breed" required>
            <input type="date" name="date_of_birth" required>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <button type="submit">Add Pet</button>
        </form>

        <h3>Your Pets</h3>
        <table>
            <tr>
                <th>Pet Name</th>
                <th>Species</th>
                <th>Breed</th>
                <th>Date of Birth</th>
                <th>Gender</th>
            </tr>
            <?php while ($pet = $pets->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $pet['pet_name']; ?></td>
                    <td><?php echo $pet['species']; ?></td>
                    <td><?php echo $pet['breed']; ?></td>
                    <td><?php echo $pet['date_of_birth']; ?></td>
                    <td><?php echo $pet['gender']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Back Button to return to user_dashboard.php -->
        <br>
        <a href="user_dashboard.php" class="button">Back to Dashboard</a>

    </div>
</body>
</html>
