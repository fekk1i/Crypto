<?php
$servername = "localhost";  // usually localhost for XAMPP
$username = "root";         // default XAMPP username
$password = "";             // default XAMPP password is empty
$dbname = "note_app";       // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// You can use $conn to interact with the database
?>
