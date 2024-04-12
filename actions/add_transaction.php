<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../settings/connection.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $date = $_POST['transaction_date'];
    $categoryId = $_POST['category_id'];
    $amount = $_POST['amount'];
    
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, category_id, transaction_date, amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisd", $userId, $categoryId, $date, $amount);

    if ($stmt->execute()) {
        
        $stmt->close();
        $conn->close();
        
        
        header('Location: ../view/transactions.php?status=success');
        exit; 
    } else {
        echo "Error adding transaction.";
    }

    $stmt->close();
    $conn->close();
}
?>
