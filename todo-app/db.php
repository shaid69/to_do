<?php
$servername = "localhost";
$username = "root";
$password = "";  // Add your MySQL password if needed
$dbname = "todo_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
