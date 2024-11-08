<?php
header('Content-Type: application/json'); // Specify JSON response

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

// Get the form data
$user_email = $_POST['user_email'] ?? '';
$item_id = $_POST['item_id'] ?? '';
$quantity = $_POST['quantity'] ?? '';

// Check if user email, item ID, and quantity are set
if (isset($user_email, $item_id, $quantity) && is_numeric($quantity)) {
    // Fetch the item's price from the items table
    $itemQuery = "SELECT price FROM items WHERE id = ?";
    $stmt = $conn->prepare($itemQuery);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price = $row['price'];
        $totalPrice = $price * $quantity;

        $sql = "INSERT INTO cart (user_email, item_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siid", $user_email, $item_id, $quantity, $totalPrice);

        if ($stmt->execute()) {
            header("Location: cart.php");
            exit();
        } else {
            echo json_encode(["error" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Item not found."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Missing user email, item ID, or quantity."]);
}

// Close the connection
$conn->close();
