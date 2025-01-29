<?php
session_start();

$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "project"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // To prevent SQL injection, use prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? and password = ? ");
    $stmt->bind_param("ss", $email , $password);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Authentication successful
            // Start a session and set session variables if needed
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            
            // Redirect to a dashboard or home page
            header("Location: dashboard.php");
            exit();
        } else {
            // Authentication failed
            echo "Invalid email/mobile or password.";
        }
    } else {
        // No user found with the given email
        echo "Invalid email/mobile or password.";
    }

    // Close statement and connection
    $stmt->close();
}

// Close connection
$conn->close();
?>