<?php
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

// Get the input data
$input = json_decode(file_get_contents("php://input"), true);
$stripe_payment_id = $input['id'];
$status = $input['status'];

// SQL query to update the status of the order
$sql = "UPDATE orders SET status = ? WHERE stripe_payment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $status, $stripe_payment_id);
$response = [];

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
