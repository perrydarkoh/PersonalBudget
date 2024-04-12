<?php
session_start();
require_once '../settings/connection.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$resources = [
    ['title' => 'How to Set Realistic Financial Goals', 'url' => 'https://www.usbank.com/wealth-management/financial-perspectives/financial-planning/how-to-set-financial-goals.html', 'description' => 'Learn the art of setting achievable financial milestones.'],
    ['title' => 'Effective Saving Strategies', 'url' => 'https://www.iciciprulife.com/investments/how-to-save-money.html', 'description' => 'Discover how to save wisely and meet your financial objectives.'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['goal_name'], $_POST['goal_amount'], $_POST['target_date'])) {
    $goalName = $_POST['goal_name'];
    $goalAmount = $_POST['goal_amount'];
    $targetDate = $_POST['target_date'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    $stmt = $conn->prepare("INSERT INTO goals (user_id, name, amount, target_date, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isiss", $userId, $goalName, $goalAmount, $targetDate, $description);
    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = "Error adding goal.";
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT id, name, amount, target_date, description FROM goals WHERE user_id = ? ORDER BY target_date ASC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$goals = [];
while ($row = $result->fetch_assoc()) {
    $goals[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Budget Goals</title>
    <link rel="stylesheet" href="../css/budgetgoals.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Set Budget Goals</h1>
            <p>Empower your financial future by setting and achieving your personal budget goals.</p>
            <nav>
                <a href="dashboard.php">Back to Dashboard</a> <!-- Link to dashboard -->
            </nav>
        </header>

        <?php if (!empty($resources)): ?>
            <section class="educational-resources">
                <h2>Educational Resources</h2>
                <ul>
                    <?php foreach ($resources as $resource): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($resource['url']); ?>" target="_blank"><?php echo htmlspecialchars($resource['title']); ?></a>
                            - <?php echo htmlspecialchars($resource['description']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="goal-setting-form">
            <h2>Create a New Goal</h2>
            <?php if (isset($success)): ?>
                <p>Your goal has been successfully added!</p>
            <?php elseif (isset($error)): ?>
                <p><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <label for="goal-name">Goal Name:</label>
                <input type="text" id="goal-name" name="goal_name" required>

                <label for="goal-amount">Goal Amount:</label>
                <input type="number" id="goal-amount" name="goal_amount" required>

                <label for="target-date">Target Date:</label>
                <input type="date" id="target-date" name="target_date" required>

                <label for="description">Description (Optional):</label>
                <textarea id="description" name="description"></textarea>

                <button type="submit">Save Goal</button>
            </form>
        </section>

        <section class="your-goals">
            <h2>Your Goals</h2>
            <?php if (!empty($goals)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Goal Name</th>
                            <th>Goal Amount</th>
                            <th>Target Date</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($goals as $goal): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($goal['name']); ?></td>
                                <td>$<?php echo number_format($goal['amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($goal['target_date']); ?></td>
                                <td><?php echo htmlspecialchars($goal['description']); ?></td>
                                <td>
                                    <form action="../actions/delete_goal.php" method="post">
                                        <input type="hidden" name="goal_id" value="<?php echo $goal['id']; ?>">
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this goal?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have not set any goals yet.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
