<?php
// update_quantity.php
include("../Config/Database.php");

// Get data from the request
$cart_id = $_POST['cart_id'] ?? '';
$quantity = $_POST['quantity'] ?? '';

// Ensure that quantity is numeric
$quantity = is_numeric($quantity) ? (float)$quantity : 0;

if ($cart_id && $quantity && is_numeric($quantity)) {
    // Step 1: Fetch the price from the cart table
    $priceQuery = "SELECT price FROM cart WHERE id = ?";
    $stmt = $conn->prepare($priceQuery);
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price = (float)$row['price']; // Get the existing price from the cart
        $totalPrice = $price * $quantity; // Calculate the new total price

        // Step 2: Update quantity and total price in the cart
        $updateQuery = "UPDATE cart SET quantity = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("idi", $quantity, $totalPrice, $cart_id);

        if ($stmt->execute()) {
            echo "Quantity updated successfully";
        } else {
            echo "Error updating quantity";
        }
    } else {
        echo "Cart item not found.";
    }

    $stmt->close();
} else {
    echo "Invalid input data";
}

$conn->close();
