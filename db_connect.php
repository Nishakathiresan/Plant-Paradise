<?php
// Database connection details
$servername = "localhost";
$username = "root";      // default XAMPP MySQL user
$password = "";          // leave blank (default for XAMPP)
$dbname = "plant_paradise";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// If connected successfully
// echo "Database connected successfully!";
?>
