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
    die("Connection failed: " . $conn->connect_error);
}


// Get the cart ID from POST data
$cart_id = $_POST['cart_id'];

// Remove the item from the cart
$sql = "DELETE FROM cart WHERE id = '$cart_id'";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}

// Close the connection
$conn->close();
?>