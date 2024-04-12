<?php
session_start();
require_once 'connection.php'; // Make sure this points to your actual database connection script

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Validate input
    if (empty($email) || empty($password)) {
        // Redirect back to the login page with an error
        header("Location: login.php?error=Please enter email and password.");
        exit;
    }

    // Prepare a select statement
    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $email);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();

            // Check if email exists, if yes then verify password
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($id, $email, $hashed_password);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, so start a new session
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $id;
                        $_SESSION["email"] = $email;                            
                        
                        // Redirect user to welcome page
                        header("Location: dashboard.php");
                    } else {
                        // Display an error message if password is not valid
                        header("Location: login.php?error=Invalid password.");
                    }
                }
            } else {
                // Display an error message if email doesn't exist
                header("Location: login.php?error=No account found with that email.");
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
