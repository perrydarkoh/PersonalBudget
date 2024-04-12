<?php
$host = 'localhost'; // or your host name/IP
$dbName = 'personal_budget_db';
$user = 'yourUsername'; // your MySQL username
$password = 'yourPassword'; // your MySQL password

// Create connection
$conn = new mysqli($host, $user, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use this $conn object for your queries
?>
