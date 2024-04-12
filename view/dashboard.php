<?php
// Start the session
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


require_once 'connection.php';


$userId = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT fullname FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


$transactionsQuery = "SELECT date, description, category, amount FROM transactions WHERE user_id = ? ORDER BY date DESC LIMIT 10";
$stmt = $conn->prepare($transactionsQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$transactionsResult = $stmt->get_result();


$stmt->close();


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Personal Budget Manager</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Dashboard</h1>
            <div>Welcome, <?php echo htmlspecialchars($user['fullname']); ?>!</div>
            <nav>
                <a href="dashboard.php">Dashboard</a> | 
                <a href="transactions.php">Transactions</a> | 
                <a href="reports.php">Reports</a> | 
                <a href="budgetgoals.php"> BudgetGoals </a> | 
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
                        <?php while($transaction = $transactionsResult->fetch_assoc()): ?>
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
