<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];

    // Database connection parameters
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

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO details (name, email, date, time, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $date, $time, $message);

    // Execute the SQL statement
    // if ($stmt->execute()) {
    //     // Appointment booked successfully
    //     $_SESSION['appointment_success'] = true;
    // } else {
    //     // Appointment booking failed
    //     $_SESSION['appointment_error'] = "Error: " . $conn->error;
    // }

    if ($stmt->execute()) {
        echo "Registration successfully completed.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the form page
    header("Location: appointment-form.php");
    exit();
}
?>