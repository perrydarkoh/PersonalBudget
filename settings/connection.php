<?php
$host = 'localhost'; 
$dbName = 'personal_budget_db';
$user = 'root'; 
$password = 'JN8mEk9FMkY:'; 


$conn = new mysqli($host, $user, $password, $dbName);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
