<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../settings/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id'], $_POST['transaction_date'], $_POST['category_id'], $_POST['amount'])) {
    $userId = $_SESSION['user_id'];
    $transactionId = $_POST['transaction_id'];
    $transactionDate = $_POST['transaction_date'];
    $categoryId = $_POST['category_id'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare("UPDATE transactions SET transaction_date = ?, category_id = ?, amount = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("siidi", $transactionDate, $categoryId, $amount, $transactionId, $userId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header('Location: ../actions/edit_transaction.php?status=success&message=Transaction updated successfully');
        } else {
            header('Location: ../actions/edit_transaction.php?status=error&message=No changes made or transaction does not exist');
        }
    } else {
        header('Location: ../actions/edit_transaction.php?status=error&message=Error updating transaction');
    }

    $stmt->close();
} else {
    header('Location: ../actions/edit_transaction.php?status=error&message=Invalid request');
}

$conn->close();
?>
