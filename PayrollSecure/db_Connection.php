<?php
$host = "localhost"; 
$username = "root";  
$password = "";     
$database = "payroll secure";

$conn = new mysqli($host, $username, $password, $database);

// Ensure UTF-8 encoding to prevent security issues
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

