<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include the database connection file
require_once 'connection.php';

$userId = $_SESSION['user_id'];

// Fetch existing budget goals
$goalsQuery = "SELECT id, category, target_amount, start_date, end_date FROM budget_goals WHERE user_id = ? ORDER BY end_date ASC";
$stmt = $conn->prepare($goalsQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$goalsResult = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Goals - Personal Budget Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Budget Goals</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a> | 
                <a href="transactions.php">Transactions</a> | 
                <a href="logout.php">Logout</a>
            </nav>
        </header>
        <main>
            <section class="goals-form">
                <h2>Add New Goal</h2>
                <!-- User feedback messages -->
                <?php
                if (isset($_GET['success'])) {
                    echo '<p class="success">' . htmlspecialchars($_GET['success']) . '</p>';
                }
                if (isset($_GET['error'])) {
                    echo '<p class="error">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                ?>
                <form action="add_goal.php" method="post">
                    <input type="text" name="category" placeholder="Category" required>
                    <input type="number" name="target_amount" placeholder="Target Amount" step="0.01" required>
                    <input type="date" name="start_date" required>
                    <input type="date" name="end_date" required>
                    <button type="submit">Add Goal</button>
                </form>
            </section>
            <section class="goals-list">
                <h2>Existing Goals</h2>
                <ul>
                    <?php while ($goal = $goalsResult->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($goal['category']) . ": $" . htmlspecialchars($goal['target_amount']) . " by " . htmlspecialchars($goal['end_date']); ?></li>
                    <?php endwhile; ?>
                </ul>
            </section>
        </main>
    </div>
</body>
</html>

<?php
$conn->close();
?>
