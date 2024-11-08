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

$size = $_POST['size'];
$embroid = $_POST['embroid'];
$color = $_POST['color'];
$font = $_POST['font'];
$quantity = $_POST['quantity'];
$item_id = $_POST['item_id'];
$user_email = $_POST['user_email'];
$price = $_POST['price'];
$totalPrice = $price * $quantity;

// Check if user email, item ID, and quantity are set
if (isset($user_email, $item_id, $quantity)) {
    // Fetch totalQty for the item
    $qty_sql = "SELECT totalQty FROM items WHERE id = '$item_id'";
    $qty_result = $conn->query($qty_sql);

    if ($qty_result->num_rows > 0) {
        $item = $qty_result->fetch_assoc();
        $totalQty = $item['totalQty'];

        // Check if requested quantity exceeds available stock
        if ($quantity > $totalQty) {
            echo json_encode(["error" => "Requested quantity exceeds available stock of $totalQty."]);
            exit();
        }

        // Insert the cart item into the database
        $sql = "INSERT INTO cart (user_email, item_id, quantity, toy_size, embroid, color, font, price) VALUES ('$user_email', '$item_id', '$quantity', '$size', '$embroid', '$color', '$font', '$totalPrice')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to cart page
            header("Location: cart.php");
            exit(); // Ensure no further code is executed
        } else {
            echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Item not found."]);
    }
} else {
    echo json_encode(["error" => "Missing user email, item ID, or quantity."]);
}

// Close the connection
$conn->close();

