<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../settings/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}


if (isset($_GET['transaction_id']) && is_numeric($_GET['transaction_id'])) {
    $transactionId = $_GET['transaction_id'];
    $userId = $_SESSION['user_id'];

    
    $stmt = $conn->prepare("DELETE FROM transactions WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $transactionId, $userId);

    
    if ($stmt->execute()) {
        
        header('Location: ../view/transactions.php?message=Transaction deleted successfully.');
    } else {
       
        header('Location: ../view/transactions.php?message=Error deleting transaction.');
    }

    $stmt->close();
} else {
 
    header('Location: ../view/transactions.php?message=Invalid transaction ID.');
}

$conn->close();
exit;
?>
