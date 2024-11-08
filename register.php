<?php
header('Content-Type: application/json'); // Add this to specify JSON response

// Database connection
$host = 'localhost';
$dbname = 'stardust';
$user = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

//Reg Post Method

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];


    $sql = "INSERT INTO users (name, email, password,contact, address) VALUES ('$name', '$email','$password','$contact', '$address')";

    if ($conn->query($sql) === TRUE) {
        // User exists
        header("Location: login-page.php");

        exit(); // Ensure no further code is executed
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

$conn->close();
