<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$dbname = 'stardust';
$user = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);

    // Execute the statement
    $stmt->execute();

    // Store result
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists
        // Set cookie for 30 minutes
        setcookie("user_email", $email, time() + (1800), "/"); 

        // Redirect to home page
        header("Location: home.php");
        exit(); // Ensure no further code is executed
    } else {
        // User does not exist
        echo json_encode(["error" => "Invalid email or password."]);
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();



