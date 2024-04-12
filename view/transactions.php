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

$query = "SELECT t.id, t.transaction_date, c.type, t.amount, c.id as category_id FROM transactions t INNER JOIN categories c ON t.category_id = c.id WHERE t.user_id = ? ORDER BY t.transaction_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

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

    <script>
    function toggleEditForm(transactionId) {
        var form = document.getElementById("edit-form-" + transactionId);
        form.style.display = form.style.display === "none" ? "table-row" : "none";
    }
    </script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Transactions</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a> |
                <a href="../login/logout.php">Logout</a>
            </nav>
        </header>
        <main>
            <section class="add-transaction">
                <h2>Add New Transaction</h2>
                <form action="../actions/add_transaction.php" method="post">
                    <label for="transaction_date">Date:</label>
                    <input type="date" id="transaction_date" name="transaction_date" required>
                    
                    <label for="category_id">Category:</label>
                    <select id="category_id" name="category_id" required>
                        <option value="1">Income</option>
                        <option value="2">Expense</option>
                    </select>
                    
                    <label for="amount">Amount:</label>
                    <input type="number" id="amount" name="amount" required>
                    
                    <button type="submit">Add Transaction</button>
                </form>
            </section>

            <section class="transactions-list">
                <h2>Recent Transactions</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($transaction = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['type']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['amount']); ?></td>
                            <td>
                                <a href="#" onclick="toggleEditForm(<?php echo $transaction['id']; ?>); return false;">Edit</a> | 
                                <a href="../actions/delete_transaction.php?transaction_id=<?php echo $transaction['id']; ?>" onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</a>
                            </td>
                        </tr>
                        <tr id="edit-form-<?php echo $transaction['id']; ?>" style="display:none;">
                            <td colspan="4">
                                <form action="../actions/edit_transaction.php" method="post">
                                    <input type="hidden" name="transaction_id" value="<?php echo $transaction['id']; ?>">
                                    Date: <input type="date" name="transaction_date" value="<?php echo $transaction['transaction_date']; ?>" required>
                                    Category: <select name="category_id" required>
                                        <option value="1" <?php echo $transaction['category_id'] == 1 ? 'selected' : ''; ?>>Income</option>
                                        <option value="2" <?php echo $transaction['category_id'] == 2 ? 'selected' : ''; ?>>Expense</option>
                                    </select>
                                    Amount: <input type="number" name="amount" value="<?php echo $transaction['amount']; ?>" required>
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
