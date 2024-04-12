<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: transactions.php');
    exit;
}

$transactionId = $_POST['transaction_id'];
$userId = $_SESSION['user_id'];
$date = $_POST['date'];
$description = $_POST['description'];
$category = $_POST['category'];
$amount = $_POST['amount'];

$query = "UPDATE transactions SET date = ?, description = ?, category = ?, amount = ? WHERE id = ? AND user_id = ?";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("sssdii", $date, $description, $category, $amount, $transactionId, $userId);
    if ($stmt->execute()) {
        header('Location: transactions.php?success=Transaction updated successfully');
    } else {
        header('Location: transactions.php?error=Failed to update transaction');
    }
    $stmt->close();
} else {
    header('Location: transactions.php?error=Failed to prepare statement');
}
$conn->close();
?>
