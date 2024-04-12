<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../settings/connection.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['goal_id'])) {
    $userId = $_SESSION['user_id'];
    $goalId = $_POST['goal_id'];

    
    $stmt = $conn->prepare("DELETE FROM goals WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $goalId, $userId);

    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();

        
        header('Location: ../view/budgetgoals.php?status=deleted');
        exit;
    } else {
        
        echo "Error deleting goal.";
    }

    $stmt->close();
} else {
   
    header('Location: ../view/budgetgoals.php');
    exit;
}

$conn->close();
?>
