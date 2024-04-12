<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'connection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $category = $_POST['category'];
    $targetAmount = $_POST['target_amount'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Prepare an insert statement
    $query = "INSERT INTO budget_goals (user_id, category, target_amount, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($query)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("issdd", $userId, $category, $targetAmount, $startDate, $endDate);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to budget goals page with success message
            header("Location: budget_goals.php?success=Goal added successfully");
        } else {
            // Redirect to budget goals page with error message
            header("Location: budget_goals.php?error=Something went wrong. Please try again.");
        }
        
        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
