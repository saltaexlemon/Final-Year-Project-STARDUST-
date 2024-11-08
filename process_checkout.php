<?php
// Database connection
$host = 'localhost';
$dbname = 'stardust';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    die("Error: No data received");
}

// Extract user email and items array
$user_email = $data['user_email'] ?? '';
$items = $data['items'] ?? [];

if (empty($user_email) || empty($items)) {
    die("Error: Missing user email or items data");
}

// Prepare and bind statements to avoid SQL injection
$sql_price = "SELECT price FROM items WHERE id = ?";
$stmt_price = $conn->prepare($sql_price);

$sql_insert = "INSERT INTO purchases (user_email, item_id, quantity, totalAmount, status) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);

if (!$stmt_price || !$stmt) {
    die("Error preparing statements: " . $conn->error);
}

$status = 'Pending';


foreach ($items as $item) {
    $item_id = intval($item['cartId']);
    $quantity = intval($item['quantity']);

    // Check if item ID and quantity are valid
    if ($item_id <= 0 || $quantity <= 0) {
        echo "Invalid item ID or quantity for item ID: $item_id";
        continue;
    }

    // Execute price query
    $stmt_price->bind_param("i", $item_id);
    $stmt_price->execute();
    $result_price = $stmt_price->get_result();

    if ($result_price->num_rows > 0) {
        $row_price = $result_price->fetch_assoc();
        $price = $row_price['price'];
        $totalAmount = $price * $quantity;

        // Insert data into purchases
        $stmt->bind_param("siids", $user_email, $item_id, $quantity, $totalAmount, $status);
        if (!$stmt->execute()) {
            echo "Error executing purchase insertion: " . $stmt->error;
        }
    } else {
        echo "Price not found for item ID: $item_id";
    }
}

// Close statements and connection
$stmt_price->close();
$stmt->close();
$conn->close();

echo "Purchase processing completed.";
?>