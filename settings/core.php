<?php
session_start(); // Start a new session or resume the existing one

// Include the database connection
require_once 'connection.php';

// You can add other common functionalities here, such as user authentication checks, etc.
function checkUserLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        // If not logged in, redirect to login page
        header("Location: login.php");
        exit();
    }
}

// You can call checkUserLoggedIn() on pages that require user to be logged in.
?>
