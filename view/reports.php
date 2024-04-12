<?php
// Start session and include database connection
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Example: Fetching monthly expenses for the last 12 months
$query = "SELECT MONTH(date) as month, SUM(amount) as total_expenses 
          FROM transactions 
          WHERE user_id = ? AND date > DATE_SUB(NOW(), INTERVAL 12 MONTH) AND amount < 0
          GROUP BY MONTH(date)
          ORDER BY date ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$monthlyExpenses = [];
while ($row = $result->fetch_assoc()) {
    $monthlyExpenses[$row['month']] = abs($row['total_expenses']);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Reports - Personal Budget Manager</title>
    <link rel="stylesheet" href="../css/reports.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Financial Reports</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a> | 
                <a href="transactions.php">Transactions</a> | 
                <a href="budgetgoals.php">Budget Goals</a> |
                <a href="logout.php">Logout</a>
            </nav>
        </header>
        <main>
            <section id="monthly-expenses">
                <h2>Monthly Expenses</h2>
                <canvas id="expensesChart"></canvas>
            </section>
            
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const monthlyExpenses = <?php echo json_encode($monthlyExpenses); ?>;
        const ctx = document.getElementById('expensesChart').getContext('2d');
        const labels = Object.keys(monthlyExpenses).map(month => `Month ${month}`);
        const data = Object.values(monthlyExpenses);

        const expensesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Expenses',
                    data: data,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {}
        });
    });
    </script>
</body>
</html>
