<?php
$host = 'localhost'; 
$dbName = 'personal_budget_db';
$user = 'root'; 
$password = ''; 

// Create connection
$conn = new mysqli($host, $user, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use this $conn object for your queries
?>
