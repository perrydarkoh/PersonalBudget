<?php
session_start();
require_once '../settings/connection.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (empty($email) || empty($password)) {
        header("Location: ../login/login.php?error=Please enter email and password.");
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();
        // print_r($user);
        // exit;


        if (password_verify($password, $user['password_hash'])) {
            $_SESSION["user_id"] = $user['id'];
            $_SESSION["email"] = $user['email'];                            
            
            header("Location: ../view/welcome_user.php");
        } else {
            header("Location: ../login/login.php?error=Invalid password.");
        }

    } else {
        header("Location: ../login/login.php?error=No account found with that email.");
    }


}

// Close connection
$conn->close();
?>
