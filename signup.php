<?php
session_start();

$servername = "localhost";
$username = "root"; // default username for XAMPP MySQL
$password = ""; // default password for XAMPP MySQL
$database = "project"; // name of your database

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
        echo "Registration successfully completed.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>