<?php
// Start the session
session_start();

// Include the database connection file
require_once 'connection.php'; // Adjust the path as needed

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input and prepare data
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an insert statement
    $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page with success message
            header("Location: login.php?success=Account created successfully. Please log in.");
        } else {
            // Redirect back to signup page with error message
            header("Location: signup.php?error=Email already in use or error creating account.");
        }
        
        // Close statement
        $stmt->close();
    } else {
        header("Location: signup.php?error=Error preparing the statement.");
    }

    // Close connection
    $conn->close();
} else {
    // Redirect to the signup page if the form wasn't submitted
    header("Location: signup.php");
    exit;
}
?>
