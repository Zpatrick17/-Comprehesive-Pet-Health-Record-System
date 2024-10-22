<?php
session_start();
include('db.php');

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

// Handle search
$search_term = '';
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
}

// Fetch all pets with optional search
$stmt = $conn->prepare("SELECT pet_id, pet_name, species, breed, date_of_birth, gender FROM pets 
                         WHERE pet_name LIKE ? OR species LIKE ? OR breed LIKE ?");
$like_term = "%" . $search_term . "%";
$stmt->bind_param("sss", $like_term, $like_term, $like_term);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pets</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>Manage Pets</h1>
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
        <h2>All Pets</h2>
        
        <!-- Search Form -->
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Search by pet name, species, or breed" value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit">Search</button>
        </form>

        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Pet Name</th><th>Species</th><th>Breed</th><th>Date of Birth</th><th>Gender</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['pet_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['species']) . "</td>";
                echo "<td>" . htmlspecialchars($row['breed']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                echo "<td>
                    <a href='edit_pet.php?pet_id=" . $row['pet_id'] . "'>Edit</a> | 
                    <a href='delete_pet.php?pet_id=" . $row['pet_id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No pets found.</p>";
        }
        ?>
    </div>
</body>
</html>
