<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect to login or form page
    header('Location: transactions.php');
    exit;
}

$userId = $_SESSION['user_id'];
$date = $_POST['date'];
$description = $_POST['description'];
$category = $_POST['category'];
$amount = $_POST['amount'];

$query = "INSERT INTO transactions (user_id, date, description, category, amount) VALUES (?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("isssd", $userId, $date, $description, $category, $amount);
    if ($stmt->execute()) {
        header('Location: transactions.php?success=Transaction added successfully');
    } else {
        header('Location: transactions.php?error=Failed to add transaction');
    }
    $stmt->close();
} else {
    header('Location: transactions.php?error=Failed to prepare statement');
}
$conn->close();
?>
