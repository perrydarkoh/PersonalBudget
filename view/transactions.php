<?php
// Start session and check for user authentication
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'connection.php'; // Ensure you have this file for DB connection

$userId = $_SESSION['user_id'];

// Fetch transactions from the database
$query = "SELECT date, description, category, amount FROM transactions WHERE user_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Close statement and connection if not needed further
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Personal Budget Manager</title>
    <link rel="stylesheet" href="../css/transactions.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Transactions</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a> | 
                <a href="logout.php">Logout</a>
            </nav>
        </header>
        <main>
            <section class="transactions-list">
                <h2>Recent Transactions</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($transaction = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['date']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['category']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['amount']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
