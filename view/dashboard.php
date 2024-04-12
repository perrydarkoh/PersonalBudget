<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once '../settings/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT fullname FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$transactionquery = "
    SELECT t.transaction_date, c.type, t.amount 
    FROM transactions t
    INNER JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = ? 
    ORDER BY t.transaction_date DESC
";

//$transactionsQuery = "SELECT id,transaction_date, amount FROM transactions WHERE user_id = ? ORDER BY transaction_date DESC LIMIT 10";

$stmt = $conn->prepare($transactionquery);
// var_dump($conn->prepare($transactionsQuery));
// exit;
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
                <a href="transactions.php">Transactions</a> |  
                <a href="budgetgoals.php"> BudgetGoals </a> | 
                <a href="../login/logout.php">Logout</a>
            </nav>
        </header>
        <main>
            <section class="transactions-list">
                <h2>Recent Transactions</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($transaction = $transactionsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['type']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
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
