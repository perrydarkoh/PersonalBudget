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
    $goalName = $_POST['goal_name'];
    $goalAmount = $_POST['goal_amount'];
    $targetDate = $_POST['target_date'];
    $description = isset($_POST['description']) ? $_POST['description'] : ''; 

    
    $stmt = $conn->prepare("INSERT INTO goals (user_id, name, amount, target_date, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isiss", $userId, $goalName, $goalAmount, $targetDate, $description);

    
    if ($stmt->execute()) {
        
        header('Location: ../view/budgetgoals.php?status=success');
        exit;
    } else {
        
        echo "Error adding goal.";
    }

    $stmt->close();
    $conn->close();
} else {
    
    header('Location: ../view/budgetgoals.php');
    exit;
}
?>
