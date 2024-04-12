<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['transaction_id'])) {
    header('Location: transactions.php');
    exit;
}

$transactionId = $_GET['transaction_id'];
$userId = $_SESSION['user_id'];

$query = "DELETE FROM transactions WHERE id = ? AND user_id = ?";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("ii", $transactionId, $userId);
    if ($stmt->execute()) {
        header('Location: transactions.php?success=Transaction deleted successfully');
    } else {
        header('Location: transactions.php?error=Failed to delete transaction');
    }
    $stmt->close();
} else {
    header('Location: transactions.php?error=Failed to prepare statement');
}
$conn->close();
?>
