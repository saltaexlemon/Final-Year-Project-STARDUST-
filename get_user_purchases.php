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

// Get email from query parameter
$email = isset($_GET['email']) ? $_GET['email'] : '';

// SQL query to fetch purchases for the given user email, including the product name and status
$sql = "SELECT orders.stripe_payment_id, orders.item_id, items.title AS product_name, orders.quantity, orders.totalAmount, orders.status
        FROM orders
        JOIN items ON orders.item_id = items.id
        WHERE orders.user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Create an array to store purchases
$purchases = [];
while ($row = $result->fetch_assoc()) {
    $purchases[] = [
        'stripe_payment_id' => $row['stripe_payment_id'],
        'item_id' => $row['item_id'],
        'product_name' => $row['product_name'],
        'quantity' => $row['quantity'],
        'totalAmount' => $row['totalAmount'],
        'status' => $row['status']
    ];
}

// Return the purchases as a JSON response
header('Content-Type: application/json');
echo json_encode($purchases);

$stmt->close();
$conn->close();
